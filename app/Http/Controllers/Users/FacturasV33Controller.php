<?php

namespace App\Http\Controllers\Users;

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
use App\Models\Impuestos;

use Auth;
use Flash;
use MultiPac;
use Session;
use SimpleXMLElement;
use LSS\Array2XML;

class FacturasV33Controller extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('user');
        $this->middleware('user.validado');
        $this->middleware('timbres.disponibles', [ 'only' => [
            'getAdd',
            'postAdd',
            'getCancelar',
        ]]);
        parent::__construct($request);
    }

    public function getIndex() {
        $facturas = Auth::user()->getFacturas();
        return $this->render('users.facturas_v33.index', compact('facturas'));
    }

    public function getNombreComprobante($nombreComprobante) {
        $f = Auth::user()->getFolioByTipo(Facturas::getTipoDocumento($nombreComprobante));
        return [ 'serie' => $f->getSerie(), 'folio' => $f->getFolio() ];
    }

    public function getAdd() {
        $impuestos = $this->obtenerImpuestos();
        return $this->render('users.facturas_v33.add', [ 'impuestos' => $impuestos ]);
    }

    public function obtenerImpuestos(){
        $impuestos_personal = Impuestos::findBy([ 'user' => Auth::user() ]);
        $impuestos = array(
                    '' => 'Seleccione un impuesto',
                    '001' => 'ISR',
                    '002' => 'IVA',
                    '003' => 'IEPS');
        return $impuestos_personal;
    }

    public function postAdd() {
        $user = Auth::user();
        $cerFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);

        $fechaFactura = new Carbon($this->request->input('fechaFactura'));
        $diasDiferencia = $fechaFactura->diffInDays(Carbon::now());
        if ($diasDiferencia > 3) {
            Flash::error('Factura fuera de fecha');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

        $nombreComprobante = Facturas::getTipoDocumento($this->request->input('nombreComprobante'));
        $tipoDocumento = Facturas::getTipoDocumento($this->request->input('nombreComprobante'));
         $f = Auth::user()->getFolioByTipo(Facturas::getTipoDocumento($this->request->input('nombreComprobante')));
         if (empty($f)) {
            Flash::error('No existe un folio configurado para ese tipo de Documento');
             return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

//        $serie = $f->getSerie();\
//        $folio = $f->getFolio();\
        $serie = $this->request->input('serie');
        $folio = $this->request->input('folio');
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
        // $formaPago = '01';
        $metodoPago = $this->request->input('metodoPago');
        // $metodoPago = 'PUE';
        $tipoCambio = '1';
        if ($this->request->input('tipoMoneda') !== 'MXN') {
            $tipoCambio = $this->request->input('tipoCambio');
        }
        $usoCFDI = $this->request->input('usoCFDI');
        // $usoCFDI = 'G01';
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
                //'TipoCambio' => $tipoCambio,
                'LugarExpedicion' => $lugarExpedicion,
            ],
            'cfdi:Emisor' => [
                '@attributes' => [
                    'Rfc' => $perfil->getRfc(),
                    'Nombre' => $perfil->getRazonSocial(),
                    // 'RegimenFiscal' => "601",
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
            'cfdi:Complemento' => [],
        ];

        $xml = Array2XML::createXML('cfdi:Comprobante', $data);
        $conceptos = $xml->getElementsByTagName('cfdi:Conceptos')[0];
        $complemento = $xml->getElementsByTagName('cfdi:Complemento')[0];

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
            // $producto = Productos::find($idProducto);
            $concepto = $xml->createElement('cfdi:Concepto');

            $impuestos = $xml->createElement('cfdi:Impuestos');
            $retenciones = $xml->createElement('cfdi:Retenciones');
            $traslados = $xml->createElement('cfdi:Traslados');

            $cantidad = $this->request->input('cantidad')[$key];
            $precio = $this->request->input('precios')[$key];
            $tipoImpuesto = $this->request->input('productos-tipo-impuesto')[$key];
            $desglose = $tipoImpuesto;
            $descuento = number_format($this->request->input('descuentos')[$key], 2, '.', '');

            if ($desglose === '1') {
                foreach ($this->request->input('traslados-tasap')[$key] as $k => $ret) {
                    if ($this->request->input('traslados-tasap')[$key][$k] !== null && is_numeric($ret)) {
                        $precio = round($this->request->input('precios')[$key] / 1.16, 6);
                        $importeTras = round((($precio * .16) * $cantidad) - $descuento, 6);
                        $iva = $importeTras;
                        $tras = number_format($this->request->input('traslados-tasap')[$key][$k] / 100, 6, '.', '');
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
                        $traslado->setAttribute('Base', number_format(($precio * $cantidad) - $descuento, 6, '.', ''));
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
                        $iva = round((($this->request->input('precios')[$key] - $precio) * $cantidad) - $descuento, 6);
                    }
                }
            } else {
                $precio = $this->request->input('precios')[$key];
                $iva = ($this->request->input('precios')[$key] * .16) * $cantidad;
            }

            //$iva = ($this->request->input('precios')[$key] * .16) * $cantidad;

            $importe = $precio * $cantidad;
            $total += $importe;
            $subTotal += $importe;

            $claveProdServ = ClaveProdServ::find($this->request->input('claves-prods-servs')[$key]);
            $claveUnidad = ClaveUnidad::find($this->request->input('claves-unidades')[$key]);
            $concepto->setAttribute('ClaveProdServ', $claveProdServ->getClave());
            $concepto->setAttribute('ClaveUnidad', $claveUnidad->getClave());
            // $concepto->setAttribute('ClaveUnidad', "B62");
            $concepto->setAttribute('NoIdentificacion', $claveProducto);
            $concepto->setAttribute('Cantidad', $cantidad);
            $concepto->setAttribute('Unidad', $this->request->input('productos-unidad')[$key]);
            $concepto->setAttribute('Descripcion', $this->request->input('productos-descripcion')[$key]);
            $concepto->setAttribute('ValorUnitario', $precio);
            $concepto->setAttribute('Importe', round($importe, 6));

             //descuento debe tener el mismo numero de decimales que el importe
            $separar = explode('.',round($importe,6));
            if(isset($separar[1])){
                $length = strlen($separar[1]);
                $descuento = number_format($descuento,$length,'.','');
            } else {
                $descuento = number_format($descuento,0,'.','');
            }
            
            $descuentos[] = $descuento;
            $concepto->setAttribute('Descuento', $descuento);

            $totalRetLocal = 0;

            if ($this->request->has('retenciones-tasap') && array_key_exists($key, $this->request->input('retenciones-tasap'))) {
                foreach ($this->request->input('retenciones-tasap')[$key] as $k => $ret) {
                    if (!empty($ret)) {
                        $ret = number_format($ret / 100, 6, '.', '');
                        $importeRet = round((($this->request->input('precios')[$key] * $cantidad) - $descuento) * $ret, 2);
                        $tipoImpuesto = $this->request->input('retenciones-tipop')[$key][$k];

                        if ($tipoImpuesto == '004') {
                            $totalRetLocal = $importeRet;
                            //$complemento = $xml->createElement('cfdi:Complemento');
                            $impuestosLocales = $xml->createElement('implocal:ImpuestosLocales');
                            $impuestosLocales->setAttribute('xmlns:implocal', 'http://www.sat.gob.mx/implocal');
                            $impuestosLocales->setAttribute('version', '1.0');
                            $impuestosLocales->setAttribute('TotaldeRetenciones', $totalRetLocal);
                            $impuestosLocales->setAttribute('TotaldeTraslados', '0.00');
                            $retLocales = $xml->createElement('implocal:RetencionesLocales');
                            $retLocales->setAttribute('ImpLocRetenido', 'Cedular');
                            $retLocales->setAttribute('TasadeRetencion', $ret*100);
                            $retLocales->setAttribute('Importe', $importeRet);

                            $impuestosLocales->appendChild($retLocales);
                            $complemento->appendChild($impuestosLocales);
                        } else {

                            if (!isset($totalesRetenciones[$tipoImpuesto])) {
                                $totalesRetenciones[$tipoImpuesto] = $this->request->input('retenciones-tipop')[$key][$k];
                                $totalesRetenciones[$tipoImpuesto] = [];
                                $totalesRetenciones[$tipoImpuesto]['Base'] = 0;
                            }
                            $totalesRetenciones[$tipoImpuesto]['Base'] += ($this->request->input('precios')[$key] * $cantidad) - $descuento;
                            $totalesRetenciones[$tipoImpuesto]['TipoFactor'] = 'Tasa';
                            if (!isset($totalesRetenciones[$tipoImpuesto]['TasaOCuota'][$ret])) {
                                $totalesRetenciones[$tipoImpuesto]['TasaOCuota'][$ret] = $ret;
                                $totalesRetenciones[$tipoImpuesto]['Importe'][$ret] = $importeRet;
                            } else {
                                $totalesRetenciones[$tipoImpuesto]['Importe'][$ret] += $importeRet;
                            }
    
                            $retencion = $xml->createElement('cfdi:Retencion');
                            $retencion->setAttribute('Base', number_format(($this->request->input('precios')[$key] * $cantidad) - $descuento, 6, '.', ''));
                            $retencion->setAttribute('Impuesto', $this->request->input('retenciones-tipop')[$key][$k]);
                            $retencion->setAttribute('TipoFactor', 'Tasa');
                            $retencion->setAttribute('TasaOCuota', $ret);
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
            }

            if ($this->request->has('traslados-tasap') && array_key_exists($key, $this->request->input('traslados-tasap')) && $desglose === '0') {
                foreach ($this->request->input('traslados-tasap')[$key] as $k => $tras) {
                    if (!empty($tras)) {
                        $tras = number_format($tras / 100, 6, '.', '');
                        $importeTras = round((($this->request->input('precios')[$key] * $cantidad) - $descuento) * $tras, 2);
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

                        $traslado = $xml->createElement('cfdi:Traslado');
                        $traslado->setAttribute('Base', number_format(($this->request->input('precios')[$key] * $cantidad) - $descuento, 6, '.', ''));
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
        $totalImpuestosTrasladados = round($totalImpuestosTrasladados, 2);
        $totalImpuestosRetenidos = round($totalImpuestosRetenidos, 2);

        $total -= $totalDescuento;
        $total += $totalImpuestosTrasladados;
        $total -= $totalImpuestosRetenidos;
        $total -= $totalRetLocal;
        if ($this->request->input('tipoMoneda') !== 'MXN') {
            $tipoCambio = $this->request->input('tipoCambio');
            $comprobante->setAttribute('TipoCambio', $tipoCambio);
        }

        $subTotal = number_format($subTotal, 2, '.', '');
        $total = number_format($total, 2, '.', '');

        $comprobante = $xml->getElementsByTagName('cfdi:Comprobante')[0];
        $comprobante->setAttribute('Total', $total);
        $comprobante->setAttribute('SubTotal', $subTotal);
        $comprobante->setAttribute('Descuento', $totalDescuento);

        $impuestosSuma = $xml->getElementsByTagName('cfdi:Impuestos')[($xml->getElementsByTagName('cfdi:Impuestos')->length) - 1];
        $impuestosSuma->setAttribute('TotalImpuestosRetenidos', $totalImpuestosRetenidos);
        $impuestosSuma->setAttribute('TotalImpuestosTrasladados', $totalImpuestosTrasladados);

        //$trasladosSuma = $xml->createElement('cfdi:Traslados');
        //$retencionesSuma = $xml->createElement('cfdi:Retenciones');

        $trasladosSuma = $xml->createElement('cfdi:Traslados');

        foreach ($totalesTraslados as $u => $totalTraslado) {
            foreach ($totalTraslado['TasaOCuota'] as $o => $tasa) {
                $trasladoSuma = $xml->createElement('cfdi:Traslado');
                $trasladoSuma->setAttribute('Impuesto', $u);
                $trasladoSuma->setAttribute('TipoFactor', $totalTraslado['TipoFactor']);
                $trasladoSuma->setAttribute('TasaOCuota', $tasa);
                $trasladoSuma->setAttribute('Importe', round($totalTraslado['Importe'][$o],2));
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
        
        // dump($nombreKey, $extKey);die;
        
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
        // dump($doc);die;
        $params = [
            'cfdiB64' => base64_encode($doc),
        ];
        //dump($params, $doc);die;

        $response = MultiPac::callTimbrarCFDI($params);
        if(is_object($response)){

        }else{
            $document = new \DOMDocument($response);
            $document->loadXML($response);
            $code = $document->getElementsByTagName('codRetorno')->item(0)->nodeValue;
            $msg = $document->getElementsByTagName('msgRetorno')->item(0)->nodeValue;

            Flash::error("Error generando la factura Codigo: {$code} - Mensaje: {$msg}");
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

        switch ($response->codRetorno) {
            case 200:
                $logo = 'null';
                if (!empty($user->getLogo()) && file_exists('uploads/users_logos/thumbnails/' . $user->getLogo()->getName())) {
                    $logo = base64_encode(file_get_contents('uploads/users_logos/thumbnails/' . $user->getLogo()->getName()));
                }
                $json = 'null';
                $comentariosPDF = $this->request->input('comentariosPDF');
                $incluirInfo = $this->request->input('incluirInfo');

                if (isset($incluirInfo)){
                    $json = base64_encode(json_encode([
                        "tipoComprobante"=> $nombreComprobante,
                        "Comentarios" => $comentariosPDF,
                        "calleEmisor"=>$perfil->getCalle(),
                        "noExteriorEmisor"=>$perfil->getNoExt(),
                        "noInteriorEmisor"=>$perfil->getNoInt(),
                        "coloniaEmisor"=>$perfil->getColonia(),
                        "codigoPostalEmisor"=>$perfil->getCodigoPostal(),
                        "localidadEmisor"=>$perfil->getLocalidad(),
                        "municipioEmisor"=>$perfil->getMunicipio(),
                        "estadoEmisor"=>$perfil->getEstado(),
                        "paisEmisor"=>$perfil->getPais(),
                        //"telefonoEmisor"=>$perfil->getTelefono(),
                        //"emailEmisor"=>$user->getEmail(),
                        "calleReceptor"=>$this->request->input('calle'),
                        "noExteriorReceptor"=>$this->request->input('noExt'),
                        "noInteriorReceptor"=>$this->request->input('noInt'),
                        "coloniaReceptor"=>$this->request->input('colonia'),
                        "codigoPostalReceptor"=>$this->request->input('codigoPostal'),
                        "localidadReceptor"=>$this->request->input('localidad'),
                        "municipioReceptor"=>$this->request->input('municipio'),
                        "estadoReceptor"=>$this->request->input('estado'),
                        "paisReceptor"=>$this->request->input('pais'), 
                    ]));
                } elseif (!empty($comentariosPDF)){
                    $json = base64_encode(json_encode([
                        "tipoComprobante"=> $nombreComprobante,
                        'Comentarios' => $comentariosPDF,
                    ]));
                } else {
                    $json = base64_encode(json_encode([
                        "tipoComprobante"=> $nombreComprobante,
                    ]));
                }

                if ($user->getPlantillaPDF()){
                    $plantilla = $user->getPlantillaPDF();
                }else{
                    $plantilla = 1;
                }

                $params = [
                    'xmlB64' => base64_encode($response->cfdiTimbrado),
                    'plantilla' => $plantilla,
                    'json' => 'null',
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

                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();
                
                $f->setFolio($folio + 1);
                $f->persist();

                $factura->flush();

                if (!empty($this->request->input('email'))) {
                    $this->sendEmail($this->request->input('email'), $this->request->input('email'), 'Factura generada',
                    'emails.facturacion.factura_generada', [], $attachments);
                }

                Flash::success('Factura generada correctamente');
                return redirect()->action('Users\FacturasV33Controller@getIndex');
            break;
            default:
                $code = $response->codRetorno;
                $msg = $response->msgRetorno;

                Flash::error("Error generando la factura Codigo: {$code} - Mensaje: {$msg}");
                return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

    }

    private function sellarXML($cfdi, $cer, $key) {
        $private = openssl_pkey_get_private(file_get_contents($key));
        $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($cer)));

        $xdoc = new \DomDocument();
        $xdoc->loadXML($cfdi) or die("XML invalido");
        $XSL = new \DomDocument();
        $XSL->load('timbrado/cadenaoriginal_3_3.xslt');

        $proc = new \XSLTProcessor();
        @$proc->importStyleSheet($XSL);
        $cadena_original = $proc->transformToXML($xdoc);
        openssl_sign($cadena_original, $sig, $private, OPENSSL_ALGO_SHA256);
        $sello = base64_encode($sig);
        $c = $xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
        $c->setAttribute('Sello', $sello);
        $c->setAttribute('Certificado', $certificado);
        return $xdoc->saveXML();
    }

    public function getCancelar($id) {
        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }

        $user = Auth::user();

        if ($factura->getUser()->getId() !== $user->getId()) {
            return redirect('/');    
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
            Flash::error('No existe un archivo KEY pem para generar la factura');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }
        if (!file_exists(public_path("uploads/users_documentos/{$nombreCer}"))) {
            Flash::error('No existe un archivo CER pem para generar la factura');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

        // dump($nombreKey);
        // dump($nombreCer);die;

        $key = file_get_contents("uploads/users_documentos/{$nombreKey}");
        $cer = file_get_contents("uploads/users_documentos/{$nombreCer}");

        $data = [
            'rfcEmisor' => $user->getPerfil()->getRfc(),
            'rfcReceptor' => $rfc,
            'Uuid' => $factura->getUuid(),
            'PrivateKeyPem' => $key,
            'PublicKeyPEM' => $cer,
            'Total' => $total,
        ];

        // dump($data);die;

        $response = MultiPac::callMethodWithNameClaveAcceso('Cancelar', $data);
        // dump($response);die;
        switch ($response->codRetorno) {
            case 201:

                $factura->setAcuse($response->acuse);
                $factura->setEstatus(Facturas::PENDIENTE);

                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();

                $factura->flush();                

                Flash::success('Acuse de cancelación de factura generado correctamente');
                return redirect()->action('Users\FacturasV33Controller@getIndex');
            break;
            default:
                Flash::error("<strong>Error generando el acuse de cancelación de factura:</strong> {$response->mensaje}");
                return redirect()->action('Users\FacturasV33Controller@getIndex');
                // return redirect()->action('Users\FacturasController@getAdd')->withInput();
        }

    }

    public function getConsultarEstado(){

    }

    public function getConsultarAutorizacionesPendientes(){

    }

    public function getAutorizarCancelacion($id){

        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }

        $user = Auth::user();

        if ($factura->getUser()->getId() !== $user->getId()) {
            return redirect('/');    
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
            Flash::error('No existe un archivo KEY pem para generar la factura');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }
        if (!file_exists(public_path("uploads/users_documentos/{$nombreCer}"))) {
            Flash::error('No existe un archivo CER pem para generar la factura');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

        // dump($nombreKey);
        // dump($nombreCer);die;

        $key = file_get_contents("uploads/users_documentos/{$nombreKey}");
        $cer = file_get_contents("uploads/users_documentos/{$nombreCer}");

        $data = [
            'rfcEmisor' => $user->getPerfil()->getRfc(),
            'rfcReceptor' => $rfc,
            'Uuid' => $factura->getUuid(),
            'PrivateKeyPem' => $key,
            'PublicKeyPEM' => $cer,
            'Respuesta' => $this->request->input('respuesta'),
        ];

        // dump($data);die;

        $response = MultiPac::callMethodWithNameClaveAcceso('Cancelar', $data);
        // dump($response);die;
        switch ($response->codRetorno) {
            case 201:

                $factura->setAcuse($response->acuse);
                $factura->setEstatus(Facturas::CANCELADA);

                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();

                $factura->flush();                

                Flash::success('Acuse de cancelación de factura generado correctamente');
                return redirect()->action('Users\FacturasV33Controller@getIndex');
            break;
            default:
                Flash::error("<strong>Error generando el acuse de cancelación de factura:</strong> {$response->mensaje}");
                return redirect()->action('Users\FacturasV33Controller@getIndex');
                // return redirect()->action('Users\FacturasController@getAdd')->withInput();
        }


    }

    public function getInvoice($id) {
        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }

        $perfil = Auth::user()->getPerfil();
        return $this->render('users.facturas_v33.invoice', compact('factura', 'perfil'));
    }

    public function getXml($id) {
        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }


      $xml = new \DOMDocument();
        $xml->loadXML($factura->getXml());
        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
        $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
        $nom = "{$serie}{$folio} - {$factura->getUuid()}";

        return response($factura->getXml())
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'aplicaction/xml')
            ->header('Content-length', strlen($factura->getXml()))
            ->header('Content-Disposition', 'attachment; filename=' . $nom . '.xml')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function getPdf($id) {
        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }


      $xml = new \DOMDocument();
        $xml->loadXML($factura->getXml());
        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
        $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
        $nom = "{$serie}{$folio} - {$factura->getUuid()}";

        $fileContents = base64_decode($factura->getPdf());

        return response($fileContents)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'aplicaction/pdf')
            ->header('Content-length', strlen($fileContents))
            ->header('Content-Disposition', 'attachment; filename=' . $nom . '.pdf')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function postEnvioEmail($id) {
        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }

        $this->sendEmail($this->request->input('email'), $this->request->input('email'), 'Factura',
                'emails.facturacion.factura_enviada', [], [ "{$factura->getUuid()}.xml" => $factura->getXml(), "{$factura->getUuid()}.pdf" => base64_decode($factura->getPdf()) ]);

        Flash::success("Factura enviada por correo electronico correctamente");
        return redirect()->action('Users\FacturasV33Controller@getIndex');
    }

    // public function getXmlEmail($id) {
    //     $factura = Facturas::find($id);

    //     if (!$factura) {
    //         return redirect('/');
    //     }

    //     $user = Auth::user();
    //     $this->sendEmail($user->getEmail(), $user->getUsername(), 'Factura',
    //             'emails.facturacion.factura_enviada', [], [ "{$factura->getUuid()}.xml" => $factura->getXml() ]);

    //     Flash::success("Factura enviada por correo electronico correctamente");
    //     return redirect()->action('Users\FacturasController@getIndex');
    // }

    // public function getPdfEmail($id) {
    //     $factura = Facturas::find($id);

    //     if (!$factura) {
    //         return redirect('/');
    //     }

    //     $user = Auth::user();
    //     $this->sendEmail($user->getEmail(), $user->getUsername(), 'Factura',
    //             'emails.facturacion.factura_enviada', [], [ "{$factura->getUuid()}.pdf" => base64_decode($factura->getPdf()) ]);

    //     Flash::success("Factura enviada por correo electronico correctamente");
    //     return redirect()->action('Users\FacturasController@getIndex');
    // }

    public function getAcuse($id) {
        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }

        $xml = new \DOMDocument();
        $xml->loadXML($factura->getXml());
        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
        $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
        $nom = "Cancelado {$serie}{$folio} - {$factura->getUuid()}";

        return response($factura->getAcuse())
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'aplicaction/xml')
            ->header('Content-length', strlen($factura->getAcuse()))
            ->header('Content-Disposition', 'attachment; filename=' . $nom . '.xml')
            ->header('Content-Transfer-Encoding', 'binary');
    }

}
