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
use App\Models\Impuestos;
use App\Models\Complementos;
use App\Models\ComplementosPagos;

use Auth;
use Flash;
use MultiPac;
use Session;
use SimpleXMLElement;
use LSS\Array2XML;

class ComplementosController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('api.user');
        $this->middleware('api.user.validado');
        $this->middleware('api.timbres.disponibles', [ 'only' => [
            'postTimbrar',
        ]]);
        parent::__construct($request);
    }

    public function postTimbrar() {
        $user = \App\Models\Users::findOneBy([ 'username' => $this->request->header('username') ]);
        $env = $user->getApiEnv();

        $cerFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);

        $fechaComp = new Carbon($this->request->input('fechaComp'));

        $tipoDocumento = 'PAGOS';
        $f = $user->getFolioByTipo($tipoDocumento);
        if (empty($f)) {
            return $this->JSONResponse([ 'data' => [ 'msj' => 'No existe un folio configurado para ese tipo de Documento' ]], false);
        }

        $serie = $f->getSerie();
        $folio = $f->getFolio();
        $fechaComp = $fechaComp->format('Y-m-d\TH:i:s');
        $noCertificado = $cerFile->getNumeroCertificado();
        //$moneda = $this->request->input('tipoMoneda');

        $formaPago = $this->request->input('formaPago');
        /*$tipoCambio = '1.0';
        if ($this->request->input('tipoMoneda') !== 'MXN') {
            $tipoCambio = $this->request->input('tipoCambio');
        }*/

        $perfil = $user->getPerfil();
        $lugarExpedicion = $perfil->getCodigoPostal();

        $data = [
            '@attributes' => [
                'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd',
                'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/3',
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                'xmlns:pago10' => 'http://www.sat.gob.mx/Pagos',
                'Version' => '3.3',
                'Serie' => $serie,
                'Folio' => $folio,
                'Fecha' => $fechaComp,
                'Sello' => '',
                'NoCertificado' => $noCertificado,
                'Certificado' => '',
                'SubTotal' => '0',
                'Moneda' => 'XXX',
                'Total' => '0',
                'TipoDeComprobante' => 'P',
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
                    'UsoCFDI' => 'P01',
                ],
            ],
            'cfdi:Conceptos' => [
                'cfdi:Concepto' => [
                    '@attributes' => [
                        'ClaveProdServ' => '84111506',
                        'Cantidad' => '1',
                        'ClaveUnidad' => 'ACT',
                        'Descripcion' => 'Pago',
                        'ValorUnitario' => '0',
                        'Importe' => '0',
                    ],
                ],
            ],
            'cfdi:Complemento' => [
                'pago10:Pagos' => [
                    '@attributes' => [
                        'Version' => '1.0',
                    ],
                ],
            ],
        ];

        $xml = Array2XML::createXML('cfdi:Comprobante', $data);
        $pagos = $xml->getElementsByTagName('pago10:Pagos')[0];

        foreach ($this->request->input('id-cfdi') as $key => $idCfdi) {
            //$cfdi = Facturas::find($idCfdi);
            $pago = $xml->createElement('pago10:Pago');
            $docRel = $xml->createElement('pago10:DoctoRelacionado');

            $folios = $this->request->input('ifolios')[$key];
            $importeAnt = $this->request->input('imontos')[$key];
            $montoPago = $this->request->input('ipagos')[$key];
            $importeNuevo = $importeAnt - $montoPago;

            $fechaPago = new Carbon($this->request->input('ifechaPago')[$key]);
            $fechaPago = $fechaPago->format('Y-m-d\TH:i:s');


            $pago->setAttribute('FechaPago', $fechaPago);
            $pago->setAttribute('FormaDePagoP', $formaPago);
            $monedaP = $this->request->input('monedaP')[$key];
            $monedaDR = $this->request->input('moneda-cfdi')[$key];
            $pago->setAttribute('MonedaP', $monedaP);
            if($monedaP !== 'MXN'){
                $pago->setAttribute('TipoCambioP',$this->request->input('tipoCambioP')[$key]);
            }
            if($monedaDR !== $monedaP){
                $pago->setAttribute('Monto', $this->request->input('montoMonedaPago')[$key]);
            }
            else{
                $pago->setAttribute('Monto', $montoPago);
            }

            
                if($this->request->has('inumOp')[$key] &&  $this->request->input('inumOp')[$key] !== ''){
                    $pago->setAttribute('NumOperacion', $this->request->input('inumOp')[$key]);
                    $pago->setAttribute('RfcEmisorCtaOrd', $this->request->input('rfcBancoOrd')[$key]);
                    $pago->setAttribute('CtaOrdenante', $this->request->input('ctaBancoOrd')[$key]);
                    $pago->setAttribute('RfcEmisorCtaBen', $this->request->input('rfcBancoBen')[$key]);
                    $pago->setAttribute('CtaBeneficiario', $this->request->input('ctaBancoBen')[$key]);
                    }
                

            //$xmlRel = new \DOMDocument();
            //$xmlRel->loadXML($cfdi->getXml()) or die("XML Rel invalido");
            //$comp = $xmlRel->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0);
            $monedaDR = $this->request->input('moneda-cfdi')[$key];
            $metodoPagoDR =  $this->request->input('metodo-cfdi')[$key];

            $parcialidad = $this->request->input('noParcialidad')[$key];

            $docRel->setAttribute('IdDocumento', $this->request->input('iUuid')[$key]);
            $docRel->setAttribute('MonedaDR', $monedaDR);
            $docRel->setAttribute('MetodoDePagoDR', $metodoPagoDR);
            if($monedaDR !== $monedaP ){
                if($monedaP == 'USD' && $monedaDR == 'MXN'){
                    $docRel->setAttribute('TipoCambioDR', '1');    
                }else{
                    $docRel->setAttribute('TipoCambioDR', $this->request->input('tipoCambioDR')[$key]);
                }
            }
            if ($metodoPagoDR == 'PPD'){
                if ($this->request->input('noParcialidad') !== '') {
                    $docRel->setAttribute('NumParcialidad', $parcialidad);
                } else {
                    $docRel->setAttribute('NumParcialidad', '1');
                }
            } else {
                $parcialidad = null;
            }
            $docRel->setAttribute('ImpSaldoAnt', $importeAnt);
            $docRel->setAttribute('ImpPagado', $montoPago);
            $docRel->setAttribute('ImpSaldoInsoluto', $importeNuevo);

            $pago->appendchild($docRel);
            $pagos->appendchild($pago);

            $cfdiTmp['documentoId'] = $idCfdi;
            $cfdiTmp['fechaPago'] = $fechaPago;
            $cfdiTmp['formaPago'] = $formaPago;
            $cfdiTmp['parcialidad'] = $parcialidad;
            $cfdiTmp['saldoAnterior'] = $importeAnt;
            $cfdiTmp['montoPago'] = $montoPago;
            $cfdiTmp['saldoInsoluto'] = $importeNuevo;

            $pagosArr[] = $cfdiTmp;

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
       //dump($params, $doc);

        $response = MultiPac::callTimbrarCFDI($params);
        //dump($response);die;
        if (is_string($response)) {
            $document = new \DomDocument($response);
            $document->loadXML($response);
            $code = $document->getElementsByTagName('codRetorno')->item(0)->nodeValue;
            $msg = $document->getElementsByTagName('msgRetorno')->item(0)->nodeValue;

            return $this->JSONResponse([ 'data' => [ 'response' => "Error generando el pago Codigo: {$code} - Mensaje: {$msg}" ]], false);
        }

        switch ($response->codRetorno) {
            case 200:
                $json = 'null';
                $json = base64_encode(json_encode([
                    "tipoComprobante"=> 'Pago',
                ]));

                /*$extras = $this->request->input('comentarios');
                if (isset($extras)){
                    $json = base64_encode(json_encode([
                        "tipoComprobante"=> 'Pago',
                        "Comentarios" => $this->request->input('comentarios'),
                ]));
                }*/

                $logo = 'null';
                if (!empty($user->getLogo()) && file_exists('uploads/users_logos/thumbnails/' . $user->getLogo()->getName())) {
                    $logo = base64_encode(file_get_contents('uploads/users_logos/thumbnails/' . $user->getLogo()->getName()));
                }
                $params = [
                    'xmlB64' => base64_encode($response->cfdiTimbrado),
                    'plantilla' => 'pagos',
                    'json' => $json,
                    'logo' => $logo,
                ];

                $complemento = new Complementos($user);
                $complemento->setUuid($response->uuid);
                $complemento->setEstatus(Complementos::TIMBRADA);
                $complemento->setSolicitudTimbre($doc);
                $complemento->setCodigoPostal($lugarExpedicion);

                $attachments = [ "{$complemento->getUuid()}.xml" => $response->cfdiTimbrado, ];
                //dump($params);
                $pdfResponse = MultiPac::generatePDFV33($params);
                //dump($pdfResponse); die;
                if ($pdfResponse->code === "210") {
                    $pdf = $pdfResponse->pdf;
                    $attachments["{$complemento->getUuid()}.pdf"] = base64_decode($pdf);
                } else {
                    $pdf = $pdfResponse->message;
                }

                $complemento->setPdf($pdf);
                $complemento->setXml($response->cfdiTimbrado);
                $complemento->set($this->request->all());

                foreach ($pagosArr as $pago) {
                    $detalle = new ComplementosPagos($complemento);
                    $detalle->set($pago);
                    $complemento->addPago($detalle);
                }

                if ($env === 'PROD') {
                    $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                    $user->persist();

                    $f->setFolio($f->getFolio() + 1);
                    $f->persist();

                    $complemento->flush();
                }

                if (!empty($this->request->input('email'))) {
                    $this->sendEmailApi($this->request->input('email'), $this->request->input('email'), 'Pago generado',
                    'emails.pagos.pago_generado', [], $attachments, $user);
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
            $factura = Complementos::findOneBy([ 'uuid' => $this->request->input('uuid') ]);
            if (!$factura) {
                $mensaje = "No existe un complemento con ese uuid";
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
                    $factura->setEstatus(Complementos::CANCELADA);

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
