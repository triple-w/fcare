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

use Auth;
use Flash;
use MultiPac;
use Session;
use SimpleXMLElement;

class FacturasController extends Controller
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
        return $this->render('users.facturas.index', compact('facturas'));
    }

    public function getAdd() {
        return $this->render('users.facturas.add');
    }

    public function postAdd() {
        $user = Auth::user();
        $certificadoPem = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);

        $subTotal = 0;
        $total = 0;
        foreach ($this->request->input('productos-clave') as $key => $idProducto) {
            $cantidad = $this->request->input('cantidad')[$key];

            $tipoImpuesto = $this->request->input('productos-tipo-impuesto')[$key];
            if ($tipoImpuesto === '1') {
                $precio = $this->request->input('precios')[$key] / 1.16;
            } else {
                $precio = $this->request->input('precios')[$key];
            }

            $importe = $precio * $cantidad;
            $total += $importe;
            $subTotal += $importe;
        }

        $descuento = 0;
        $tipoDescuento = $this->request->input('tipoDescuento');
        if ($tipoDescuento === 'porcentaje') {
            if (!empty($this->request->input('descuento'))) { 
                $descuento = $this->request->input('descuento');
                $descuento = $subTotal * ($descuento / 100);
            }
        } else {
            $descuento = floatval($this->request->input('descuento'));
        }
        $subTotal -= $descuento;

        $countImpuestosTras = 0;
        $sumImpuestosTras = 0;
        if ($this->request->has('tasaImpuestosTras')) {
            foreach ($this->request->input('tasaImpuestosTras') as $key => $value) {
                if ($value !== "") {
                    $valor = $this->request->input('valorImpuestosTras')[$key];
                    $sumImpuestosTras += $valor;
                    $total += $valor;
                    $countImpuestosTras++;
                }
            }
        }

        $countImpuestosRet = 0;
        $sumImpuestosRet = 0;
        if ($this->request->has('tipoImpuestosRet')) {
            foreach ($this->request->input('tipoImpuestosRet') as $key => $value) {
                if ($value !== "") {
                    $valor = $this->request->input('valorImpuestosRet')[$key];

                    $valorImpuesto = ($subTotal * ($valor / 100));
                    $sumImpuestosRet += $valorImpuesto;

                    $total -= $valorImpuesto;
                    $countImpuestosRet++;
                }
            }
        }

        $nuevosImpuestosRet = [];
        $nuevosImpuestosTras = [];
        $sumNuevosImpuestosRet = 0;
        $sumNuevosImpuestosTras = 0;
        if ($this->request->has('nuevosImpuestoNombre')) {
            foreach ($this->request->input('nuevosImpuestoNombre') as $key => $value) {
                if ($value !== "") {
                    $valor = $this->request->input('nuevosImpuestoTasa')[$key];
                    $valorImpuesto = ($subTotal * ($valor / 100));

                    $tipo = $this->request->input('nuevosImpuestoTipo');

                    if ($tipo === 'TRASLADO') {
                        $nuevosImpuestosTras[] = [
                            'nombre' => $value,
                            'tasa' => $this->request->input('nuevosImpuestoTasa')[$key],
                            'valor' => $valor,
                        ];
                        $sumNuevosImpuestosRet +=  $valorImpuesto;
                        $total += $valorImpuesto;
                        $countImpuestosTras++;
                    } else {
                        $nuevosImpuestosRet[] = [
                            'nombre' => $value,
                            'tasa' => $this->request->input('nuevosImpuestoTasa')[$key],
                            'valor' => $valor,
                        ];
                        $sumNuevosImpuestosTras +=  $valorImpuesto;
                        $total -= $valorImpuesto;
                        $countImpuestosRet++;
                    }
                }
            }
        }

        $total -= $descuento;
        $tipoCambio = '1.0';
        if ($this->request->input('tipoMoneda') !== 'MXN') {
            $tipoCambio = $this->request->input('tipoCambio');
        }

        $lugarExpedicion = "{$user->getPerfil()->getMunicipio()}, {$user->getPerfil()->getEstado()}";

        $fechaFactura = new Carbon($this->request->input('fechaFactura'));
        $diasDiferencia = $fechaFactura->diffInDays(Carbon::now());
        if ($diasDiferencia > 3) {
            Flash::error('No se puede facturar con mas de 2 dias de diferencia');
            return redirect()->action('Users\FacturasController@getIndex');
        }

        $tipoDocumento = strtolower(Facturas::getTipoDocumento($this->request->input('nombreComprobante')));
        $f = Auth::user()->getFolioByTipo(Facturas::getTipoDocumento($this->request->input('nombreComprobante')));
        if (empty($f)) {
            Flash::error('No existe un folio configurado para ese tipo de Documento');
            return redirect()->action('Users\FacturasController@getIndex');
        }

        $serie = $f->getSerie();
        $folio = $f->getFolio();

        $str = 'DATOS CFDI' . PHP_EOL;
        $str .= '3.2' . '|' .
        $serie . '|' .
        $folio . '|' .
        // \Carbon\Carbon::now()->toAtomString() . '|' .
        $fechaFactura->format('Y-m-d\TH:i:s') . '|' .
        // '2016-08-05T16:41:59' . '|' .
        $this->request->input('formaPago') . '|' .
        $certificadoPem->getNumeroCertificado() . '|' .
        'cond' . '|' .
        number_format($subTotal, 3, '.', '') . '|' .
        number_format($descuento, 3, '.', '') . '|' .
        $this->request->input('motivoDescuento') . '|' .
        $tipoCambio . '|' .
        $this->request->input('tipoMoneda') . '|' .
        number_format($total, 3, '.', '') . '|' .
        $tipoDocumento . '|'.
        $this->request->input('metodoPago') . '|'.
        $lugarExpedicion . '|'.
        $this->request->input('numeroCuentaPago') . '|' .
        '' . '|' .
        '' . '|' .
        '' . '|'.
        '' . '|' . PHP_EOL;

        $perfil = $user->getPerfil();
        $str .= 'EMISOR DE LA FACTURA' .  PHP_EOL;
        $str .= $perfil->getRfc() . '|' .
        $perfil->getRazonSocial() . '|' . PHP_EOL;

        $str .= 'DOMICILIO FISCAL DEL EMISOR' . PHP_EOL;
        $str .= $perfil->getCalle() . '|' .
        $perfil->getNoExt() . '|' .
        $perfil->getNoInt() . '|' .
        $perfil->getColonia() . '|' .
        $perfil->getLocalidad() . '|' .
        '|' .
        $perfil->getMunicipio() . '|' .
        $perfil->getEstado() . '|' .
        $perfil->getPais() . '|' .
        $perfil->getCodigoPostal() . '|' . PHP_EOL;

        $str .= 'DOMICILIO DONDE SE EXPIDE LA FACTURA' . PHP_EOL;
        $str .= $perfil->getCalle() . '|' .
        $perfil->getNoExt() . '|' .
        $perfil->getNoInt() . '|' .
        $perfil->getColonia() . '|' .
        $perfil->getLocalidad() . '|' .
         '|' .
        $perfil->getMunicipio() . '|' .
        $perfil->getEstado() . '|' .
        $perfil->getPais() . '|' .
        $perfil->getCodigoPostal() . '|' . PHP_EOL;

        $str .= 'REGIMEN FISCAL' . PHP_EOL;
        $str .= '1|' .
        $perfil->getNombreRegimen() . '|' . PHP_EOL;

        // $cliente = Clientes::find($this->request->input('cliente'));

        $str .= 'RECEPTOR DE LA FACTURA' . PHP_EOL;
        $str .= $this->request->input('rfc') . '|' .
        $this->request->input('razonSocial') . '|' . PHP_EOL;

        $str .= 'DOMICILIO FISCAL DEL RECEPTOR' . PHP_EOL;
        $str .= $this->request->input('calle') . '|' .
        $this->request->input('noExt') . '|' .
        $this->request->input('noInt') . '|' .
        $this->request->input('colonia') . '|' .
        $this->request->input('localidad') . '|' .
        '|' .
        $this->request->input('municipio') . '|' .
        $this->request->input('estado') . '|' .
        $this->request->input('pais') . '|' .
        $this->request->input('codigoPostal') . '|' . PHP_EOL;

        $str .= 'CONCEPTOS DE LA FACTURA' . PHP_EOL;
        $str .= count($this->request->input('productos-clave')) . PHP_EOL;

        $productos = [];
        foreach ($this->request->input('productos-clave') as $key => $claveProducto) {
            // $producto = Productos::find($idProducto);
            $cantidad = $this->request->input('cantidad')[$key];
            $tipoImpuesto = $this->request->input('productos-tipo-impuesto')[$key];
            $precio = $this->request->input('precios')[$key];
            if ($tipoImpuesto === '1') {
                $precio = $this->request->input('precios')[$key] / 1.16;
                $iva = ($this->request->input('precios')[$key] - $precio) * $cantidad;
            } else {
                $precio = $this->request->input('precios')[$key];
                $iva = ($this->request->input('precios')[$key] * .16) * $cantidad;
            }
            $importe = $precio * $cantidad;

            $str .= $cantidad . '|' .
            $this->request->input('productos-unidad')[$key] . '|' .
            $claveProducto . '|' .
            $this->request->input('productos-descripcion')[$key] . '|' .
            number_format($precio, 3, '.', ''). '|' .
            number_format($importe, 3, '.', '') . '|' . PHP_EOL;

            // $productosTmp = $producto->toArray(null, [ 'relationships' => false ]);            
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

        $str .= 'IMPUESTOS DE LA FACTURA' . PHP_EOL;
        $str .= $countImpuestosRet . '|'.
        $countImpuestosTras . '|' . PHP_EOL;

        $str .= 'TOTAL DE IMPUESTOS' . PHP_EOL;
        $str .= $this->request->has('valorImpuestosRet') ? number_format(array_sum($this->request->input('valorImpuestosRet')), 3, '.', '') : '0.00';
        $str .= $this->request->has('valorImpuestosTras') ? '|' . number_format(array_sum($this->request->input('valorImpuestosTras')), 3, '.', '') : '|0.00';
        $str .= '|' . PHP_EOL;

        $impuestos = [];
        if ($this->request->has('valorImpuestosRet')) {
            foreach ($this->request->input('tipoImpuestosRet') as $key => $value) {
                if ($value !== "") {
                    $tipo = 'RET';
                    $valor = $this->request->input('valorImpuestosRet')[$key];

                    $str .= $tipo . '|' .
                    $value . '|'  .
                    $valor . '|' . PHP_EOL;

                    $impuestosTmp['tipo'] = $tipo;
                    $impuestosTmp['impuesto'] = $value;
                    $impuestosTmp['monto'] = $valor;

                    $impuestos[] = $impuestosTmp;
                }
            }
        }
        foreach ($nuevosImpuestosRet as $imp) {
            if ($imp !== "") {
                $tipo = 'RET';

                $str .= $tipo . '|' .
                $imp['nombre']. '|'  .
                $imp['valor'] . '|' . PHP_EOL;

                $impuestosTmp['tipo'] = $tipo;
                $impuestosTmp['impuesto'] = $value;
                $impuestosTmp['monto'] = $valor;

                $impuestos[] = $impuestosTmp;
            }
        }

        if ($this->request->has('tasaImpuestosTras')) {
            foreach ($this->request->input('tasaImpuestosTras') as $key => $value) {
                if ($value !== "") {
                    $tipo = 'TRAS';
                    $valor = $this->request->input('valorImpuestosTras')[$key];
                    $impuestoTipo = $key;
                    $tasa = $value;

                    $str .= $tipo . '|' .
                    $impuestoTipo . '|'  .
                    $tasa. '|' .
                    $valor . '|' . PHP_EOL;

                    $impuestosTmp['tipo'] = $tipo;
                    $impuestosTmp['impuesto'] = $impuestoTipo;
                    $impuestosTmp['monto'] = $valor;
                    $impuestosTmp['tasa'] = $tasa;

                    $impuestos[] = $impuestosTmp;
                }
            }
        }

        foreach ($nuevosImpuestosTras as $imp) {
            if ($imp !== "") {
                $tipo = 'TRAS';

                $str .= $tipo . '|' .
                $imp['nombre'] . '|'  .
                $imp['tasa']. '|' .
                $imp['valor'] . '|' . PHP_EOL;

                $impuestosTmp['tipo'] = $tipo;
                $impuestosTmp['impuesto'] = $imp['nombre'];
                $impuestosTmp['monto'] = $imp['valor'];
                $impuestosTmp['tasa'] = $imp['tasa'];

                $impuestos[] = $impuestosTmp;

            }
        }

        $str .= PHP_EOL;
        $strComprobante = $this->request->input('nombreComprobante');
        // dump(Facturas::FACTURA, $strComprobante);die;
        $nombreComprobante = constant("App\Models\Facturas::$strComprobante");
        // dump($nombreComprobante);die;
        $str .= 'NOMBRE COMPROBANTE|' . $nombreComprobante . '|' . PHP_EOL;
        $str .= PHP_EOL;
        if (!empty($this->request->input('comentariosPDF'))) {
            $str .= 'COMENTARIOS EN PDF|' . PHP_EOL;
            $str .= 'COMENTARIO|' . htmlentities($this->request->input('comentariosPDF')) . '|' . PHP_EOL;
        }

        $keyPem = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::LLAVE);
        // dump($keyPem, $certificadoPem);die;
        // dump(file_exists(public_path("uploads/users_documentos/{$keyPem->getName()}.pem")));die;

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
            return redirect()->action('Users\FacturasController@getIndex');
        }
        if (!file_exists(public_path("uploads/users_documentos/{$nombreCer}"))) {
            Flash::error('No existe un archivo CER pem para generar la factura');
            return redirect()->action('Users\FacturasController@getIndex');
        }

        $key = file_get_contents("uploads/users_documentos/{$nombreKey}");
        $cer = file_get_contents("uploads/users_documentos/{$nombreCer}");
        // $strPrueba = file_get_contents('timbrado/example_txt_cfdi.txt');
        // dump($str, $strPrueba);die;
        // $strOtro = "";
        // dump($str, $key, $cer);die;
        // $str = "";
        $data = [
            'txt' => $str,
            'key' => $key,
            'cer' => $cer,
            'plantilla' => $user->getPlantilla()
        ];

        //dump($str);die;
        // dump($data);die;

        $response = MultiPac::callMethod('timbrarTxt3', $data);
        // dump($response);die;
        switch ($response->codigo) {
            case 200:

                $sxe = new SimpleXMLElement($response->timbre);
                $ns = $sxe->getNamespaces(true);
                // $sxe->registerXPathNamespace('c', $ns['cfdi']);
                $sxe->registerXPathNamespace('t', $ns['tfd']);

                $uudi = "";
                foreach ($sxe->xpath('//t:TimbreFiscalDigital') as $tfd) {
                    // echo "{$tfd['selloCFD']}<br />";
                    // echo "{$tfd['FechaTimbrado']}<br />";
                    $uuid = $tfd['UUID'];
                    // echo "{$tfd['noCertificadoSAT']}<br />";
                    // echo "{$tfd['version']}<br />";
                    // echo "{$tfd['selloSAT']}<br />";
                }

                $factura = new Facturas($user);
                $factura->setUuid($uuid);
                $factura->setDescuento($descuento);
                $factura->setEstatus(Facturas::TIMBRADA);
                $factura->setSolicitudTimbre($str);
                $factura->setPdf($response->pdf);
                $factura->setXml($response->timbre);
                $factura->set($this->request->all());

                foreach ($productos as $producto) {
                    $detalle = new FacturasDetalles($factura);
                    $detalle->set($producto);
                    $factura->addDetalle($detalle);
                }

                foreach ($impuestos as $impuesto) {
                    $impuestoEntity = new FacturasImpuestos($factura);
                    $impuestoEntity->set($impuesto);
                    $factura->addImpuesto($impuestoEntity);
                }

                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();

                $f->setFolio($f->getFolio() + 1);
                $f->persist();

                $factura->flush();

                if (!empty($this->request->input('email'))) {
                    $this->sendEmail($this->request->input('email'), $this->request->input('email'), 'Factura generada',
                    'emails.facturacion.factura_generada', [], [ "{$factura->getUuid()}.xml" => $response->timbre, "{$factura->getUuid()}.pdf" => base64_decode($response->pdf) ]);
                }

                Flash::success('Factura generada correctamente');
                return redirect()->action('Users\FacturasController@getIndex');
            break;
            default:
                Flash::error("<strong>Error generando la factura:</strong> {$response->mensaje}");
                return redirect()->action('Users\FacturasController@getIndex');
                // return redirect()->action('Users\FacturasController@getAdd')->withInput();
        }

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
            return redirect()->action('Users\FacturasController@getIndex');
        }
        if (!file_exists(public_path("uploads/users_documentos/{$nombreCer}"))) {
            Flash::error('No existe un archivo CER pem para generar la factura');
            return redirect()->action('Users\FacturasController@getIndex');
        }

        // dump($nombreKey);
        // dump($nombreCer);die;

        $key = file_get_contents("uploads/users_documentos/{$nombreKey}");
        $cer = file_get_contents("uploads/users_documentos/{$nombreCer}");

        $data = [
            'rfcEmisor' => $user->getPerfil()->getRfc(),
            'uuid' => $factura->getUuid(),
            'keyPEM' => $key,
            'cerPEM' => $cer,
        ];

        // dump($data);die;

        $response = MultiPac::callMethodWithNameClaveAcceso('cancelarCFDI', $data);
        // dump($response);die;
        switch ($response->codRetorno) {
            case 201:

                $factura->setAcuse($response->acuse);
                $factura->setEstatus(Facturas::CANCELADA);

                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();

                $factura->flush();                

                Flash::success('Factura cancelada correctamente');
                return redirect()->action('Users\FacturasController@getIndex');
            break;
            default:
                Flash::error("<strong>Error generando la factura:</strong> {$response->mensaje}");
                return redirect()->action('Users\FacturasController@getIndex');
                // return redirect()->action('Users\FacturasController@getAdd')->withInput();
        }

    }

    public function getInvoice($id) {
        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }

        $perfil = Auth::user()->getPerfil();
        return $this->render('users.facturas.invoice', compact('factura', 'perfil'));
    }

    public function postFacturar() {

    }    

    public function getXml($id) {
        $factura = Facturas::find($id);

        if (!$factura) {
            return redirect('/');
        }

        $textos = explode("\n", $factura->getSolicitudTimbre());
        $linea = explode("|", $textos[1]);
        $nom = "{$linea[1]}{$linea[2]} - {$factura->getUuid()}";

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

        $textos = explode("\n", $factura->getSolicitudTimbre());
        $linea = explode("|", $textos[1]);
        $nom = "{$linea[1]}{$linea[2]} - {$factura->getUuid()}";

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
        return redirect()->action('Users\FacturasController@getIndex');
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



}
