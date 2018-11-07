<?php
namespace App\Http\Controllers\APIUsers\v1\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Models\Clientes;
use App\Models\Folios;
use App\Models\Productos;
use App\Models\Facturas;
use App\Models\FacturasDetalles;
use App\Models\FacturasImpuestos;
use App\Models\UsersInfoFacturaDocumentos;
use App\Models\ClaveProdServ;
use App\Models\ClaveUnidad;

use Auth;
use Flash;
use MultiPac;
use Session;
use SimpleXMLElement;
use LSS\Array2XML;

class FacturasController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('api.user');
        $this->middleware('api.user.validado');
        $this->middleware('api.timbres.disponibles', [ 'only' => [
            'postFacturar',
        ]]);
        parent::__construct($request);
    }

    public function postFacturar() {
        $user = \App\Models\Users::findOneBy([ 'username' => $this->request->header('username') ]);
        $env = $user->getApiEnv();

        $cerFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);

        $fechaFactura = new Carbon($this->request->input('fechaFactura'));
        $diasDiferencia = $fechaFactura->diffInDays(Carbon::now());
        if ($diasDiferencia > 3) {
            return $this->JSONResponse([ 'data' => [ 'msj' => 'Factura fuera de fecha' ]], false);
        }

        $tipoDocumento = Facturas::getTipoDocumento($this->request->input('nombreComprobante'));
        $f = $user->getFolioByTipo(Facturas::getTipoDocumento($this->request->input('nombreComprobante')));
        if (empty($f)) {
            return $this->JSONResponse([ 'data' => [ 'msj' => 'No existe un folio configurado para ese tipo de Documento' ]], false);
        }

        $serie = $f->getSerie();
        $folio = $f->getFolio();
        $fechaFactura = $fechaFactura->format('Y-m-d\TH:i:s');
        $noCertificado = $cerFile->getNumeroCertificado();
        $moneda = $this->request->input('tipoMoneda');
        $tipoComprobante = '';
        switch ($tipoDocumento) {
            case Facturas::INGRESO:
                $tipoComprobante = 'I';
                break;
            case Facturas::EGRESO:
                $tipoComprobante = 'E';
                break;
            case Facturas::TRASLADO:
                $tipoComprobante = 'T';
                break;
        }
        $formaPago = $this->request->input('formaPago');
        $metodoPago = $this->request->input('metodoPago');
        $tipoCambio = '1.0';
        if ($this->request->input('tipoMoneda') !== 'MXN') {
            $tipoCambio = $this->request->input('tipoCambio');
        }
        $usoCFDI = $this->request->input('usoCFDI');
        $perfil = $user->getPerfil();
        $lugarExpedicion = $perfil->getCodigoPostal();

        $data = [
            '@attributes' => [
                'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd',
                'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/3',
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                'Version' => '3.3',
                'Serie' => $serie,
                'Folio' => $folio,
                'Fecha' => $fechaFactura,
                'Sello' => '',
                'NoCertificado' => $noCertificado,
                'Certificado' => '',
                'SubTotal' => '',
                'Moneda' => $moneda,
                'Total' => '',
                'TipoDeComprobante' => $tipoComprobante,
                'FormaPago' => $formaPago,
                'MetodoPago' => $metodoPago,
                'TipoCambio' => $tipoCambio,
                'LugarExpedicion' => $lugarExpedicion,
            ],
            'cfdi:Emisor' => [
                '@attributes' => [
                    'Rfc' => $perfil->getRfc(),
                    'Nombre' => $perfil->getRazonSocial(),
                    'RegimenFiscal' => $perfil->getNumeroRegimen33(),
                ],
            ],
            'cfdi:Receptor' => [
                '@attributes' => [
                    'Rfc' => $this->request->input('rfc'),
                    'Nombre' => $this->request->input('razonSocial'),
                    'UsoCFDI' => $usoCFDI,
                ],
            ],
            'cfdi:Conceptos' => [],
            'cfdi:Impuestos' => [
                '@attributes' => [
                    'TotalImpuestosRetenidos' => '',
                    'TotalImpuestosTrasladados' => '',
                ],
            ],
        ];

        $xml = Array2XML::createXML('cfdi:Comprobante', $data);
        $conceptos = $xml->getElementsByTagName('cfdi:Conceptos')[0];

        $subTotal = 0;
        $total = 0;
        $productos = [];
        $descuentos = [];
        $impuestosProd = [];
        $totalImpuestosRetenidos = 0;
        $totalImpuestosTrasladados = 0;
        $totalesTraslados = [];
        $totalesRetenciones = [];
        foreach ($this->request->input('productos-clave') as $key => $claveProducto) {
            $impuestosTmp = [];
            $concepto = $xml->createElement('cfdi:Concepto');

            $impuestos = $xml->createElement('cfdi:Impuestos');
            $retenciones = $xml->createElement('cfdi:Retenciones');
            $traslados = $xml->createElement('cfdi:Traslados');

            $cantidad = $this->request->input('cantidad')[$key];
            $tipoImpuesto = $this->request->input('productos-tipo-impuesto')[$key];
            $precio = $this->request->input('precios')[$key];
            $descuento = number_format($this->request->input('descuentos')[$key], 2, '.', '');
            if ($tipoImpuesto === '1') {
                foreach ($this->request->input('traslados-tasap')[$key] as $k => $ret) {
                    if ($this->request->input('traslados-tasap')[$key][$k] !== null && is_numeric($ret)) {
                        $precio = $this->request->input('precios')[$key] / 1.16;
                        $importeTras = number_format((($this->request->input('precios')[$key] - $precio) * $cantidad) - $descuento, 2, '.', '');
                        $iva = $importeTras;
                        $tras = number_format($this->request->input('traslados-tasap')[$key][$k], 6, '.', '');
                        $tipoImpuesto = $this->request->input('traslados-tipop')[$key][$k];
                        if (!isset($totalesTraslados[$tipoImpuesto])) {
                            $totalesTraslados[$tipoImpuesto] = $this->request->input('traslados-tipop')[$key][$k];
                            $totalesTraslados[$tipoImpuesto] = [];
                            $totalesTraslados[$tipoImpuesto]['Base'] = 0;
                        }
                        $totalesTraslados[$tipoImpuesto]['Base'] += ($this->request->input('precios')[$key] * $cantidad) - $descuento;
                        $totalesTraslados[$tipoImpuesto]['TipoFactor'] = 'Tasa';
                        if (!isset($totalesTraslados[$tipoImpuesto]['TasaOCuota'][$tras])) {
                            $totalesTraslados[$tipoImpuesto]['TasaOCuota'][$tras] = $tras;
                            $totalesTraslados[$tipoImpuesto]['Importe'][$tras] = $importeTras;
                        } else {
                            $totalesTraslados[$tipoImpuesto]['Importe'][$tras] += $importeTras;
                        }

                        $traslado= $xml->createElement('cfdi:Traslado');
                        $traslado->setAttribute('Base', number_format(($this->request->input('precios')[$key] * $cantidad) - $descuento, 2, '.', ''));
                        $traslado->setAttribute('Impuesto', $this->request->input('traslados-tipop')[$key][$k]);
                        $traslado->setAttribute('TipoFactor', 'Tasa');
                        $traslado->setAttribute('TasaOCuota', $tras);
                        $traslado->setAttribute('Importe', $importeTras);
                        $traslados->appendChild($traslado);
                        $totalImpuestosTrasladados += $importeTras;

                        $impuestosTmp['tipo'] = 'TRAS';
                        $impuestosTmp['impuesto'] = $this->request->input('traslados-tipop')[$key][$k];
                        $impuestosTmp['monto'] = $importeTras;
                        $impuestosTmp['tasa'] = $tras;
                    } else {
                        $iva = number_format((($this->request->input('precios')[$key] - $precio) * $cantidad) - $descuento, 2, '.', '');
                    }
                }
            } else {
                $precio = $this->request->input('precios')[$key];
                $iva = ($this->request->input('precios')[$key] * .16) * $cantidad;
            }

            $importe = $precio * $cantidad;
            $total += $importe;
            $subTotal += $importe;

            $claveProdServ = $this->request->input('claves-prods-servs')[$key];
            $claveUnidad = $this->request->input('claves-unidades')[$key];
            $concepto->setAttribute('ClaveProdServ', $claveProdServ);
            $concepto->setAttribute('ClaveUnidad', $claveUnidad);
            $concepto->setAttribute('NoIdentificacion', $claveProducto);
            $concepto->setAttribute('Cantidad', $cantidad);
            $concepto->setAttribute('Unidad', $this->request->input('productos-unidad')[$key]);
            $concepto->setAttribute('Descripcion', $this->request->input('productos-descripcion')[$key]);
            $concepto->setAttribute('ValorUnitario', $this->request->input('precios')[$key]);
            $concepto->setAttribute('Importe', number_format($importe, 2, '.', ''));

            $descuentos[] = $descuento;

            $concepto->setAttribute('Descuento', $descuento);

            if ($this->request->has('retenciones-tasap') && array_key_exists($key, $this->request->input('retenciones-tasap'))) {
                foreach ($this->request->input('retenciones-tasap')[$key] as $k => $ret) {
                    if (!empty($this->request->input('retenciones-tasap')[$key][$k]) && is_numeric($ret)) {
                        $cantidad = $this->request->input('cantidad')[$key];
                        $ret = number_format($ret / 100, 6, '.', '');
                        $importeRet = number_format((($this->request->input('precios')[$key] * $cantidad) - $descuento) * $ret, 2, '.', '');
                        $tipoImpuesto = $this->request->input('retenciones-tipop')[$key][$k];
                        if (!isset($totalesRetenciones[$tipoImpuesto])) {
                            $totalesRetenciones[$tipoImpuesto] = $this->request->input('retenciones-tipop')[$key][$k];
                            $totalesRetenciones[$tipoImpuesto] = [];
                            $totalesRetenciones[$tipoImpuesto]['Base'] = 0;
                        }
                        $totalesRetenciones[$tipoImpuesto]['Base'] += ($this->request->input('precios')[$key] * $cantidad) - $descuento;
                        $totalesRetenciones[$tipoImpuesto]['TipoFactor'] = 'Tasa';
                        if (!isset($totalesRetenciones[$tipoImpuesto]['TasaOCuota'])) {
                            $totalesRetenciones[$tipoImpuesto]['TasaOCuota'][$tras] = $tras;
                            $totalesRetenciones[$tipoImpuesto]['Importe'][$ret] = $importeRet;
                        } else {
                            $totalesRetenciones[$tipoImpuesto]['Importe'][$ret] += $importeRet;
                        }

                        $retencion = $xml->createElement('cfdi:Retencion');
                        $retencion->setAttribute('Base', number_format(($this->request->input('precios')[$key] * $cantidad) - $descuento, 2, '.', ''));
                        $retencion->setAttribute('Impuesto', $this->request->input('retenciones-tipop')[$key][$k]);
                        $retencion->setAttribute('TipoFactor', 'Tasa');
                        $retencion->setAttribute('TasaOCuota', number_format($ret, 4, '.', ''));
                        // $retencion->setAttribute('TasaOCuota', '0.160000');
                        $retencion->setAttribute('Importe', $importeRet);
                        $retenciones->appendChild($retencion);
                        $totalImpuestosRetenidos += $importeRet;

                        $impuestosTmp['tipo'] = 'RET';
                        $impuestosTmp['impuesto'] = $this->request->input('retenciones-tipop')[$key][$k];
                        $impuestosTmp['monto'] = $importeRet;
                        $impuestosTmp['tasa'] = $ret;
                    }
                }
            }

            if ($this->request->has('traslados-tasap') && array_key_exists($key, $this->request->input('traslados-tasap'))) {
                foreach ($this->request->input('traslados-tasap')[$key] as $k => $tras) {
                    if (!empty($tras)) {
                        $cantidad = $this->request->input('cantidad')[$key];
                        $tras = number_format($tras / 100, 6, '.', '');
                        $importeTras = number_format(($this->request->input('precios')[$key] * $cantidad) * $tras, 2, '.', '');
                        $tipoImpuesto = $this->request->input('traslados-tipop')[$key][$k];
                        if (!isset($totalesTraslados[$tipoImpuesto])) {
                            $totalesTraslados[$tipoImpuesto] = $this->request->input('traslados-tipop')[$key][$k];
                            $totalesTraslados[$tipoImpuesto] = [];
                            $totalesTraslados[$tipoImpuesto]['Base'] = 0;
                        }
                        $totalesTraslados[$tipoImpuesto]['Base'] += $this->request->input('precios')[$key] * $cantidad;
                        $totalesTraslados[$tipoImpuesto]['TipoFactor'] = 'Tasa';
                        if (!isset($totalesTraslados[$tipoImpuesto]['TasaOCuota'])) {
                            $totalesTraslados[$tipoImpuesto]['TasaOCuota'][$tras] = $tras;
                            $totalesTraslados[$tipoImpuesto]['Importe'][$tras] = $importeTras;
                        } else {
                            $totalesTraslados[$tipoImpuesto]['Importe'][$tras] += $importeTras;
                        }

                        $traslado = $xml->createElement('cfdi:Traslado');
                        $traslado->setAttribute('Base', $this->request->input('precios')[$key] * $cantidad);
                        $traslado->setAttribute('Impuesto', $this->request->input('traslados-tipop')[$key][$k]);
                        $traslado->setAttribute('TipoFactor', 'Tasa');
                        $traslado->setAttribute('TasaOCuota', $tras);
                        $traslado->setAttribute('Importe', $importeTras);
                        $traslados->appendChild($traslado);
                        $totalImpuestosTrasladados += $importeTras;

                        $impuestosTmp['tipo'] = 'TRAS';
                        $impuestosTmp['impuesto'] = $this->request->input('traslados-tipop')[$key][$k];
                        $impuestosTmp['monto'] = $importeTras;
                        $impuestosTmp['tasa'] = $tras;
                    }
                }
            }

            if (!empty($impuestosTmp)) {
                $impuestosProd[] = $impuestosTmp;
            }

            if ($traslados->childNodes->length > 0) {
                $impuestos->appendchild($traslados);
            }
            if ($retenciones->childNodes->length > 0) {
                $impuestos->appendchild($retenciones);
            }
            if ($impuestos->childNodes->length > 0) {
                $concepto->appendChild($impuestos);
            }
            $conceptos->appendchild($concepto);

            $productosTmp['clave'] = $claveProducto;
            $productosTmp['observaciones'] = $this->request->input('productos-observaciones')[$key];
            $productosTmp['unidad'] = $this->request->input('productos-unidad')[$key];
            $productosTmp['precio'] = $this->request->input('precios')[$key];
            $productosTmp['descripcion'] = $this->request->input('productos-descripcion')[$key];

            $productosTmp['cantidad'] = $cantidad;
            $productosTmp['importe'] = $importe;
            $productosTmp['iva'] = $iva;
            $productosTmp['desglosado'] = $this->request->input('productos-tipo-impuesto')[$key];;
            $productosTmp['nuevoPrecio'] = $this->request->input('precios')[$key];

            $productos[] = $productosTmp;

        }

        $totalDescuento = number_format(array_sum($descuentos), 2, '.', '');
        $total -= $totalDescuento;
        $total += $totalImpuestosTrasladados;
        $total -= $totalImpuestosRetenidos;

        $subTotal = number_format($subTotal, 2, '.', '');
        $total = number_format($total, 2, '.', '');

        $comprobante = $xml->getElementsByTagName('cfdi:Comprobante')[0];
        $comprobante->setAttribute('Total', $total);
        $comprobante->setAttribute('SubTotal', $subTotal);
        $comprobante->setAttribute('Descuento', $totalDescuento);

        $impuestosSuma = $xml->getElementsByTagName('cfdi:Impuestos')[($xml->getElementsByTagName('cfdi:Impuestos')->length) - 1];
        $impuestosSuma->setAttribute('TotalImpuestosRetenidos', number_format($totalImpuestosRetenidos, 2, '.', ''));
        $impuestosSuma->setAttribute('TotalImpuestosTrasladados', number_format($totalImpuestosTrasladados, 2, '.', ''));

        $trasladosSuma = $xml->createElement('cfdi:Traslados');
        foreach ($totalesTraslados as $u => $totalTraslado) {
            foreach ($totalTraslado['TasaOCuota'] as $o => $tasa) {
                $trasladoSuma = $xml->createElement('cfdi:Traslado');
                $trasladoSuma->setAttribute('Impuesto', $u);
                $trasladoSuma->setAttribute('TipoFactor', $totalTraslado['TipoFactor']);
                $trasladoSuma->setAttribute('TasaOCuota', $tasa);
                $trasladoSuma->setAttribute('Importe', $totalTraslado['Importe'][$o]);
                $trasladosSuma->appendChild($trasladoSuma);
            }
        }

        $retencionesSuma = $xml->createElement('cfdi:Retenciones');
        foreach ($totalesRetenciones as $u => $totalRetencion) {
            foreach ($totalRetencion['TasaOCuota'] as $o => $tasa) {
                $retencionSuma = $xml->createElement('cfdi:Retencion');
                $retencionSuma->setAttribute('Impuesto', $u);
                // $retencionSuma->setAttribute('TipoFactor', $totalRetencion['TipoFactor']);
                // $retencionSuma->setAttribute('TasaOCuota', $tasa);
                $retencionSuma->setAttribute('Importe', $totalRetencion['Importe'][$o]);
                $retencionesSuma->appendChild($retencionSuma);
            }
        }

        if ($retencionesSuma->childNodes->length > 0) {
            $impuestosSuma->appendChild($retencionesSuma);
        }
        if ($trasladosSuma->childNodes->length > 0) {
            $impuestosSuma->appendChild($trasladosSuma);
        }

        $keyFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::LLAVE);
        $nombreKey = $keyFile->getName();
        $extKey = pathinfo($nombreKey, PATHINFO_EXTENSION);
        if ($extKey === 'key') {
            $nombreKey .= '.pem';
        }
        $path = "uploads/users_documentos/";
        $params = [
            'xmlB64' => base64_encode($xml->saveXml()),
            'keyPEMB64' => base64_encode(file_get_contents($path . $nombreKey)),
        ];

        $response = Multipac::generateSelloV33($params);
        // $doc = $this->sellarXML($xml->saveXML(), $path . $cerFile->getName(), $path . $nombreKey);\
        // dump(base64_encode($doc), $doc);die;
        $domDoc = new \DomDocument();
        $domDoc->loadXML($xml->saveXml()) or die("XML invalido");
        $c = $domDoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0);
        $c->setAttribute('Sello', $response->sello);
        $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($path . $cerFile->getName())));
        $c->setAttribute('Certificado', $certificado);
        $doc = $domDoc->savexml();
        //dump($doc);die;
        $params = [
            'cfdiB64' => base64_encode($doc),
        ];
        // dump($params, $doc);die;

        $response = MultiPac::callTimbrarCFDI($params);
        if (is_string($response)) {
            $document = new \DOMDocument($response);
            $document->loadXML($response);
            $code = $document->getElementsByTagName('codRetorno')->item(0)->nodeValue;
            $msg = $document->getElementsByTagName('msgRetorno')->item(0)->nodeValue;

            return $this->JSONResponse([ 'data' => [ 'response' => "Error generando la fatucar Codigo: {$code} - Mensaje: {$msg}" ]], false);
        }

        switch ($response->codRetorno) {
            case 200:
                $extras = [];
                if ($this->request->has('comentarios')) {
                    $extras['Comentarios'] = $this->request->input('comentarios');
                }

                $logo = 'null';
                if (!empty($user->getLogo()) && file_exists('uploads/users_logos/thumbnails/' . $user->getLogo()->getName())) {
                    $logo = base64_encode(file_get_contents('uploads/users_logos/thumbnails/' . $user->getLogo()->getName()));
                }
                $params = [
                    'xmlB64' => base64_encode($response->cfdiTimbrado),
                    'plantilla' => 1,
                    'json' => !empty($extras) ? base64_encode(json_encode($extras)) : 'null',
                    'logo' => $logo,
                ];

                $factura = new Facturas($user);
                $factura->setUuid($response->uuid);
                $factura->setDescuento($descuento);
                $factura->setEstatus(Facturas::TIMBRADA);
                $factura->setSolicitudTimbre($doc);

                $attachments = [ "{$factura->getUuid()}.xml" => $response->cfdiTimbrado, ];
                $pdfResponse = MultiPac::generatePDFV33($params);
                if ($pdfResponse->code === "210") {
                    $pdf = $pdfResponse->pdf;
                    $attachments["{$factura->getUuid()}.pdf"] = base64_decode($pdf);
                } else {
                    $pdf = $pdfResponse->message;
                }

                $factura->setPdf($pdf);
                $factura->setXml($response->cfdiTimbrado);
                $factura->set($this->request->all());

                foreach ($productos as $producto) {
                    $detalle = new FacturasDetalles($factura);
                    $detalle->set($producto);
                    $factura->addDetalle($detalle);
                }

                foreach ($impuestosProd as $impuesto) {
                    $impuestoEntity = new FacturasImpuestos($factura);
                    $impuestoEntity->set($impuesto);
                    $factura->addImpuesto($impuestoEntity);
                }

                if ($env === 'PROD') {
                    $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                    $user->persist();

                    $f->setFolio($f->getFolio() + 1);
                    $f->persist();

                    $factura->flush();
                }

                if (!empty($this->request->input('email'))) {
                    $this->sendEmailApi($this->request->input('email'), $this->request->input('email'), 'Factura generada',
                    'emails.facturacion.factura_generada', [], $attachments, $user);
                }

                $responseAPI = (array) $response;
                $responseAPI['pdf'] = $pdf;
                return $this->JSONResponse($responseAPI);
            break;
            default:
                $responseAPI = (array) $response;
                return $this->JSONResponse($responseAPI, false);
        }

    }

    public function postCancelar() {
        $user = \App\Models\Users::findOneBy([ 'username' => $this->request->header('username') ]);
        $env = $user->getApiEnv();

        if ($env === 'PROD') {
            $factura = Facturas::findOneBy([ 'uuid' => $this->request->input('uuid') ]);
            if (!$factura) {
                $mensaje = "No existe una factura con ese uuid";
                return $this->JSONResponse([ 'mensaje' => $mensaje ]);
            }

            if ($factura->getUser()->getId() !== $user->getId()) {
                $mensaje = "Error de acceso";
                return $this->JSONResponse([ 'mensaje' => $mensaje ]);
            }
        }

        $certificadoPem = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);
        $keyPem = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::LLAVE);

        $nombreKey = $keyPem->getName();
        $nombreCer = $certificadoPem->getName();
        $extKey = pathinfo($nombreKey, PATHINFO_EXTENSION);
        $extCer = pathinfo($nombreCer, PATHINFO_EXTENSION);

        if ($extKey === 'key') {
            $nombreKey .= '.pem';
        }
        if ($extCer === 'cer') {
            $nombreCer .= '.pem';
        }
        if (!file_exists(public_path("uploads/users_documentos/{$nombreKey}"))) {
            $mensaje = "No existe un archivo KEY pem para generar la factura";
            return $this->JSONResponse([ 'mensaje' => $mensaje ]);
        }
        if (!file_exists(public_path("uploads/users_documentos/{$nombreCer}"))) {
            $mensaje = "No existe un archivo CER pem para generar la factura";
            return $this->JSONResponse([ 'mensaje' => $mensaje ]);
        }

        // dump($nombreKey);
        // dump($nombreCer);die;

        $key = file_get_contents("uploads/users_documentos/{$nombreKey}");
        $cer = file_get_contents("uploads/users_documentos/{$nombreCer}");

        $data = [
            'rfcEmisor' => $user->getPerfil()->getRfc(),
            'uuid' => $this->request->input('uuid'),
            'keyPEM' => $key,
            'cerPEM' => $cer,
        ];

        // dump($data);die;

        $response = MultiPac::callMethodWithNameClaveAcceso('cancelarCFDI', $data);
        // dump($response);die;
        switch ($response->codRetorno) {
            case 201:
                if ($env === 'PROD') {
                    $factura->setAcuse($response->acuse);
                    $factura->setEstatus(Facturas::CANCELADA);

                    $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                    $user->persist();

                    $factura->flush();
                }

                $responseAPI = (array) $response;
                return $this->JSONResponse($responseAPI);
            break;
            default:
                $responseAPI = (array) $response;
                return $this->JSONResponse($responseAPI);
                // return redirect()->action('Users\FacturasController@getAdd')->withInput();
        }

    }
}

?>
