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
use App\Models\Complementos;
use App\Models\ComplementosPagos;

use Auth;
use Flash;
use MultiPac;
use Session;
use SimpleXMLElement;
use LSS\Array2XML;

class ComplementosV33Controller extends Controller
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
        $complementos = Complementos::getComplementos(Auth::user());
        return $this->render('users.complementos.index', compact('complementos'));
    }

    public function getAdd() {
        $facturas = Auth::user()->getFacturas();
        return $this->render('users.complementos.add', [ 'facturas' => $facturas ]);
    }

    public function getCfdiByCliente() {
        $facturas = Auth::user()->getFacturas();
        $rfc = $this->request->input('rfc');
        $html = '<select id="cfdis" class="form-control select2-hidden-accessible" name="nFacturas" tabindex="-1" aria-hidden="true">';
        foreach($facturas as $factura){
            if($factura->getRfc() == $rfc){
                $xml = new \DOMDocument();
                $xml->loadXML($factura->getXml());
                $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0);
                $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
                $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
                $html .= '<option value="'.$factura->getId().'">'.$serie.$folio.' - '.$factura->getUuid().' - $'.$factura->getMontoTotal($xml).'</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    public function getInfoCfdi() {
        $id = $this->request->input('id');
        $factura = Facturas::find($id);
        $uuid = $factura->getUuid();
        $xml = new \DOMDocument();
        $xml->loadXML($factura->getXml());
        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0);
        $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
        $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
        $total = $comprobante->getAttribute('Total');
        $moneda = $comprobante->getAttribute('Moneda');
        $metodoPago =  $comprobante->getAttribute('MetodoPago');
        $restante = ComplementosPagos::getUltimoPago($id);
        if(!empty($restante)){
            foreach($restante as $res){
                $saldoInsoluto = $res['saldoInsoluto'];
            }
        } else {
            $saldoInsoluto = $total;
        }
        $info = array(
            'id' => $id,
            'uuid' => $uuid,
            'serie' => $serie,
            'folio' => $folio,
            'moneda' => $moneda,
            'metodoPago' => $metodoPago,
            'saldoInsoluto' => $saldoInsoluto,
        );
        return $info;
    }

    public function postAdd() {
        $user = Auth::user();
        $cerFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);

        $fecha = new Carbon($this->request->input('fecha'));
        //$fecha = Carbon::now();

        $tipoDocumento = 'PAGOS';
        $f = Auth::user()->getFolioByTipo($tipoDocumento);
        if (empty($f)) {
            Flash::error('No existe un folio configurado para ese tipo de Documento');
            return redirect()->action('Users\ComplementosV33Controller@getIndex');
        }

        $serie = $f->getSerie();
        $folio = $f->getFolio();
        $fecha = $fecha->format('Y-m-d\TH:i:s');
        $noCertificado = $cerFile->getNumeroCertificado();
        $moneda = $this->request->input('tipoMoneda');

        $formaPago = $this->request->input('formaPago');
        $tipoCambio = '1.0';
        if ($this->request->input('tipoMoneda') !== 'MXN') {
            $tipoCambio = $this->request->input('tipoCambio');
        }

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
                'Fecha' => $fecha,
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

            $monedaDR = $this->request->input('moneda-cfdi')[$key];

            $pago->setAttribute('FechaPago', $fechaPago);
            $pago->setAttribute('FormaDePagoP', $formaPago);
            $monedaP = $this->request->input('moneda-pago')[$key];
            $pago->setAttribute('MonedaP', $monedaP);
            if($monedaP !== 'MXN'){
                $pago->setAttribute('TipoCambioP',$this->request->input('tipo-cambio')[$key]);
            }
            if($monedaDR !== $monedaP){
              if($monedaP == 'MXN'){
                $montoPagoIngresado = round(((1/($this->request->input('tipo-cambio')[$key]))*$montoPago), 2);
                $pago->setAttribute('Monto', $montoPagoIngresado);
              }else {
                $montoPagoIngresado = round(($montoPago/($this->request->input('tipo-cambio')[$key])), 2);
                $pago->setAttribute('Monto', $montoPagoIngresado);
              }
            }else{
              $pago->setAttribute('Monto', $montoPago);
            }

            if($this->request->has('inumOp') &&  $this->request->input('inumOp')[$key] !== ''){
                $pago->setAttribute('NumOperacion', $this->request->input('inumOp')[$key]);
                $pago->setAttribute('RfcEmisorCtaOrd', $this->request->input('ibcoEmisor')[$key]);
                $pago->setAttribute('CtaOrdenante', $this->request->input('ictaOrd')[$key]);
                $pago->setAttribute('RfcEmisorCtaBen', $this->request->input('ibcoReceptor')[$key]);
                $pago->setAttribute('CtaBeneficiario', $this->request->input('ictaBen')[$key]);
            }

            //$xmlRel = new \DOMDocument();
            //$xmlRel->loadXML($cfdi->getXml()) or die("XML Rel invalido");
            //$comp = $xmlRel->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
           // $monedaDR = $this->request->input('moneda-cfdi')[$key];
            $metodoPagoDR =  $this->request->input('metodo-cfdi')[$key];

            $parcialidad = $this->request->input('noParcialidad');

            $docRel->setAttribute('IdDocumento', $this->request->input('iUuid')[$key]);
            $docRel->setAttribute('MonedaDR', $monedaDR);
            if($monedaDR !== $monedaP ){
                if($monedaP == 'USD' && $monedaDR == 'MXN'){
                    $docRel->setAttribute('TipoCambioDR', '1');    
                }else{
                    $docRel->setAttribute('TipoCambioDR', $this->request->input('tipo-cambio')[$key]);
                }
            }
            $docRel->setAttribute('MetodoDePagoDR', $metodoPagoDR);
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

        $comprobante = $xml->getElementsByTagName('cfdi:Comprobante')[0];

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
        $domDoc = new \DomDocument();
        $domDoc->loadXML($xml->saveXml()) or die("XML invalido");
        $c = $domDoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
        $c->setAttribute('Sello', $response->sello);
        $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($path . $cerFile->getName())));
        $c->setAttribute('Certificado', $certificado);
        $doc = $domDoc->savexml();
        $params = [
            'cfdiB64' => base64_encode($doc),
        ];

        //dump($params, $doc);die; //<--mostrar sello y xml

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
                //$comentariosPDF = $this->request->input('comentariosPDF');
                $incluirInfo = $this->request->input('incluirInfo');

                $json = base64_encode(json_encode([
                    "tipoComprobante"=> 'Pago',
                ]));
                
                if (isset($incluirInfo)){
                    $json = base64_encode(json_encode([
                        "tipoComprobante"=> 'Pago',
                        //"Comentarios" => $comentariosPDF,
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

                $attachments = [ "{$complemento->getUuid()}.xml" => $response->cfdiTimbrado, ];
                $pdfResponse = MultiPac::generatePDFV33($params);
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

                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();

                $f->setFolio($f->getFolio() + 1);
                $f->persist();

                $complemento->flush();

                if (!empty($this->request->input('email'))) {
                    $this->sendEmail($this->request->input('email'), $this->request->input('email'), 'Pago recibido',
                    'emails.pagos.pago_generado', [], $attachments);
                }

                Flash::success('Pago generado correctamente');
                return redirect()->action('Users\ComplementosV33Controller@getIndex');
            break;
            default:
                $code = $response->codRetorno;
                $msg = $response->msgRetorno;

                Flash::error("Error generando el pago. Código: {$code} - Mensaje: {$msg}");
                return redirect()->action('Users\ComplementosV33Controller@getIndex');
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
        $complemento = Complementos::find($id);

        if (!$complemento) {
            return redirect('/');
        }

        $user = Auth::user();

        if ($complemento->getUser()->getId() !== $user->getId()) {
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
            Flash::error('No existe un archivo KEY pem para generar el pago');
            return redirect()->action('Users\ComplementosV33Controller@getIndex');
        }
        if (!file_exists(public_path("uploads/users_documentos/{$nombreCer}"))) {
            Flash::error('No existe un archivo CER pem para generar el pago');
            return redirect()->action('Users\ComplementosV33Controller@getIndex');
        }

        // dump($nombreKey);
        // dump($nombreCer);die;

        $key = file_get_contents("uploads/users_documentos/{$nombreKey}");
        $cer = file_get_contents("uploads/users_documentos/{$nombreCer}");

        $data = [
            'rfcEmisor' => $user->getPerfil()->getRfc(),
            'uuid' => $complemento->getUuid(),
            'keyPEM' => $key,
            'cerPEM' => $cer,
        ];

        // dump($data);die;

        $response = MultiPac::callMethodWithNameClaveAcceso('cancelarCFDI', $data);
        // dump($response);die;
        switch ($response->codRetorno) {
            case 201:

                $complemento->setAcuse($response->acuse);
                $complemento->setEstatus(Complementos::CANCELADA);

                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();

                $pagos = ComplementosPagos::findBy([ 'complemento' => $id]);
                foreach ($pagos as $pago) {
                    $parcialidadCancelar = $pago->getParcialidad();
                    if ($parcialidadCancelar > 1) {
                        $parcialidadPut = $parcialidadCancelar - 1;
                    }else{
                        $parcialidadPut = null;
                    }
                    $pago->setParcialidad($parcialidadPut);
                    $montoCancelar = $pago->getMontoPago();
                    $saldoInsolutoCancelar = $pago->getSaldoInsoluto();
                    $pago->setMontoPago("0");
                    $pago->setSaldoInsoluto($saldoInsolutoCancelar + $montoCancelar);
                    $pago->flush();
                }
                
                $complemento->flush();

                Flash::success('Pago cancelado correctamente');
                return redirect()->action('Users\ComplementosV33Controller@getIndex');
            break;
            default:
                Flash::error("<strong>Error cancelando el pago:</strong> {$response->mensaje}");
                return redirect()->action('Users\ComplementosV33Controller@getIndex');
        }

    }

    public function getInvoice($id) {
        $complemento = Complementos::find($id);

        if (!$complemento) {
            return redirect('/');
        }

        $perfil = Auth::user()->getPerfil();
        return $this->render('users.facturas_v33.invoice', compact('complemento', 'perfil'));
    }

    public function postFacturar() {

    }

    public function getXml($id) {
        $complemento = Complementos::find($id);

        if (!$complemento) {
            return redirect('/');
        }

        $xml = new \DOMDocument();
        $xml->loadXML($complemento->getXml());
        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
        $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
        $nom = "{$serie}{$folio} - {$complemento->getUuid()}";

        return response($complemento->getXml())
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'aplicaction/xml')
            ->header('Content-length', strlen($complemento->getXml()))
            ->header('Content-Disposition', 'attachment; filename=' . $nom . '.xml')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function getPdf($id) {
        $complemento = Complementos::find($id);

        if (!$complemento) {
            return redirect('/');
        }

        $xml = new \DOMDocument();
        $xml->loadXML($complemento->getXml());
        $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
        $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
        $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
        $nom = "{$serie}{$folio} - {$complemento->getUuid()}";

        $fileContents = base64_decode($complemento->getPdf());

        return response($fileContents)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'aplicaction/pdf')
            ->header('Content-length', strlen($fileContents))
            ->header('Content-Disposition', 'attachment; filename=' . $nom . '.pdf')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function postEnvioEmail($id) {
        $complemento = Complementos::find($id);

        if (!$complemento) {
            return redirect('/');
        }

        $this->sendEmail($this->request->input('email'), $this->request->input('email'), 'Complemento de pago',
                'emails.pagos.pago_enviado', [], [ "{$complemento->getUuid()}.xml" => $complemento->getXml(), "{$complemento->getUuid()}.pdf" => base64_decode($complemento->getPdf()) ]);

        Flash::success("Complemento de pago enviado por correo electronico correctamente");
        return redirect()->action('Users\ComplementosV33Controller@getIndex');
    }
    
}