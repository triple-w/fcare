<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Facturas;
use App\Models\Clientes;
use App\Models\Folios;
use App\Models\Productos;
use App\Models\UsersInfoFacturaDocumentos;
use App\Models\ClaveProdServ;
use App\Models\ClaveUnidad;

use Auth;
use Flash;
use MultiPac;
use Session;
use SimpleXMLElement;
use LSS\Array2XML;
use Carbon\Carbon;

class FacturasV33ComplementosController extends Controller
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
        $complementos = Auth::user()->getFacturasComplementos();
        return $this->render('users.facturas_v33.complementos.index', compact('complementos'));
    }

    public function getAdd() {
        return $this->render('users.facturas_v33.complementos.add');
    }

    public function postAdd() {
        $user = Auth::user();
        $cerFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);

        $fechaFactura = new Carbon($this->request->input('fechaFactura'));

        $tipoDocumento = strtolower(Facturas::getTipoDocumento($this->request->input('nombreComprobante')));
        $f = Auth::user()->getFolioByTipo(Facturas::getTipoDocumento($this->request->input('nombreComprobante')));
        if (empty($f)) {
            Flash::error('No existe un folio configurado para ese tipo de Documento');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

        $serie = $f->getSerie();
        $folio = $f->getFolio();
        $fechaFactura = $fechaFactura->format('Y-m-d\TH:i:s');
        $noCertificado = $cerFile->getNumeroCertificado();
        $moneda = $this->request->input('tipoMoneda');
        $tipoComprobante = 'I';
        $formaPago = $this->request->input('formaPago');
        // $formaPago = '01';
        $metodoPago = $this->request->input('metodoPago');
        // $metodoPago = 'PUE';
        $tipoCambio = '1.0';
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
                'xmlns:pago10' => 'http://www.sat.gob.mx/Pagos',
                'Version' => '3.3',
                'Serie' => $serie,
                'Folio' => $folio,
                'Sello' => '',
                'Fecha' => $fechaFactura,
                'Moneda' => 'XXX',
                'NoCertificado' => $noCertificado,
                'Certificado' => '',
                'SubTotal' => '0',
                'Total' => '0',
                'TipoDeComprobante' => 'P',
                'LugarExpedicion' => $lugarExpedicion,
                'UsoCFDI' => "P01",
            ],
            'cfdi:Emisor' => [
                '@attributes' => [
                    'Rfc' => $perfil->getRfc(),
                    'Nombre' => $perfil->getRazonSocial(),
                    'RegimenFiscal' => "601",
                    // 'RegimenFiscal' => $perfil->getNumeroRegimen(),
                ],
            ],
            'cfdi:Receptor' => [
                '@attributes' => [
                    'Rfc' => $this->request->input('rfc'),
                    'Nombre' => $this->request->input('razonSocial'),
                    'UsoCFDI' => "P01",
                ],
            ],
            'cfdi:Conceptos' => [],
            'cfdi:Complemento' => [
                'pago10:Pagos' => [
                    '@attributes' => [
                        'Version' => '1.0',
                        'xsi:schemaLocation' => 'http://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd',
                    ],
                    'pago10:Pago' => [
                        '@attributes' => [
                            'FechaPago' => $fechaFactura,
                            'FormaDePagoP' => '06',
                            'MonedaP' => 'MXN',
                            'Monto' => '10000',
                            'RfcEmisorCtaOrd' => 'XEXX010101000',
                            'CtaOrdenante' => '1234567890',
                            'NomBancoOrdExt' => '1234567890',
                        ]
                    ]
                ]
            ],
        ];

        $xml = Array2XML::createXML('cfdi:Comprobante', $data);
        $conceptos = $xml->getElementsByTagName('cfdi:Conceptos')[0];

        foreach ($this->request->input('productos-clave') as $key => $claveProducto) {
            $claveProdServ = ClaveProdServ::find($this->request->input('claves-prods-servs')[$key]);
            $claveUnidad = ClaveUnidad::find($this->request->input('claves-unidades')[$key]);
            $cantidad = $this->request->input('cantidad')[$key];
            $concepto = $xml->createElement('cfdi:Concepto');
            $concepto->setAttribute('ClaveProdServ', '84111506');
            // $concepto->setAttribute('ClaveUnidad', $claveUnidad->getClave());
            $concepto->setAttribute('ClaveUnidad', "ACT");
            $concepto->setAttribute('Cantidad', $cantidad);
            $concepto->setAttribute('Descripcion', 'Pago');
            $concepto->setAttribute('ValorUnitario', 0);
            $concepto->setAttribute('Importe', 0);
            $conceptos->appendchild($concepto);
        }
        $pago = $xml->getElementsByTagName('pago10:Pago')[0];
        foreach ($this->request->input('uuids') as $key => $uuid) {
            $docRelacionado = $xml->createElement('pago10:DoctoRelacionado');
            $docRelacionado->setAttribute('IdDocumento', $uuid);
            $docRelacionado->setAttribute('MonedaDR', 'MXN');
            $docRelacionado->setAttribute('TipoCambioDR', '1');
            $docRelacionado->setAttribute('MetodoDePagoDR', $this->request->input('metodos-pagos-dr')[$key]);
            $docRelacionado->setAttribute('NumParcialidad', $this->request->input('numeros-parcialidades')[$key]);
            $docRelacionado->setAttribute('ImpSaldoAnt', $this->request->input('saldos-anteriores')[$key]);
            $docRelacionado->setAttribute('ImpPagado', $this->request->input('importes-pagados')[$key]);
            $docRelacionado->setAttribute('ImpSaldoInsoluto', $this->request->input('saldos-anteriores')[$key] - $this->request->input('importes-pagados')[$key]);
            $pago->appendChild($docRelacionado);
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
        $c = $xml->getElementsByTagName('cfdi:Comprobante')->item(0); 
        $c->setAttribute('Sello', $response->sello);
        $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($path . $cerFile->getName())));
        $c->setAttribute('Certificado', $certificado);
        $doc = $xml->savexml();

        // $doc = file_get_contents('timbrado/PagosCfdi33.xml');
        dump($doc);die;
        $params = [
            'cfdiB64' => base64_encode($doc),
        ];

        $response = MultiPac::callTimbrarCFDI($params);
        dump($response);die;
    }

}
