<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use LSS\Array2XML;
use Carbon\Carbon;

use App\Models\UsersInfoFacturaDocumentos;
use App\Models\Folios;
use App\Models\Empleados;
use App\Models\Nominas;
use App\Models\NominasOtrosPagos;
use App\Models\NominasDeducciones;
use App\Models\NominasPercepciones;

use Auth;
use MultiPac;
use Flash;

class NominasController extends Controller
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
        $nominas = Auth::user()->getNominas();
        return $this->render('users.nominas.index', compact('nominas'));
    }

    public function getAdd() {
        return $this->render('users.nominas.add');
    }

    public function postAdd() {
        $user = Auth::user();
        $f = $user->getFolioByTipo(Folios::EGRESO);
        if (empty($f)) {
            Flash::error('No existe un folio configurado para ese tipo de Documento');
            return redirect()->action('Users\NominasController@getIndex');
        }
        $serie = $f->getSerie();
        $folio = $f->getFolio();
        $fechaFactura = Carbon::now();
        $fechaFactura = $fechaFactura->format('Y-m-d\TH:i:s');

        $codigoPostal = $user->getPerfil()->getCodigoPostal();
        $perfil = $user->getPerfil();

        $empleado = Empleados::find($this->request->input('empleado'));
        $fechaPago = $this->request->input('fechaPago');
        $fechaInicialPago = $this->request->input('fechaInicialPago');
        $fechaFinalPago = $this->request->input('fechaFinalPago');
        $numDiasPagados = $this->request->input('numDiasPagados');

        $pers = $this->request->input('percepciones-claves');
        $totalPers = 0;
        $totalGravados = 0;
        $totalExentos = 0;
        $totalSueldos = 0;
        $totalJubilacion = 0;
        $totalIndemnizacion = 0;
        foreach ($pers as $key => $per) {
            $totalGravados += $this->request->input('percepciones-gravados')[$key];
            $totalExentos += $this->request->input('percepciones-excentos')[$key];
            if ($this->request->input('percepciones-conceptos')[$key] !== "022"
                || $this->request->input('percepciones-conceptos')[$key] !== "023"
                || $this->request->input('percepciones-conceptos')[$key] !== "025"
                || $this->request->input('percepciones-conceptos')[$key] !== "039"
                || $this->request->input('percepciones-conceptos')[$key] !== "044"
            ) {
                $totalSueldos += $this->request->input('percepciones-gravados')[$key] + $this->request->input('percepciones-excentos')[$key];
            }
            if ($this->request->input('percepciones-conceptos')[$key] === "039"
                || $this->request->input('percepciones-conceptos')[$key] === "044"
            ) {
                $totalJubilacion += $this->request->input('percepciones-gravados')[$key] + $this->request->input('percepciones-excentos')[$key];
            }
            if ($this->request->input('percepciones-conceptos')[$key] === "022"
                || $this->request->input('percepciones-conceptos')[$key] === "023"
                || $this->request->input('percepciones-conceptos')[$key] === "025"
            ) {
                $totalIndemnizacion += $this->request->input('percepciones-gravados')[$key] + $this->request->input('percepciones-excentos')[$key];
            }
        }
        $totalPers += $totalSueldos + $totalJubilacion + $totalIndemnizacion;

        $deds = $this->request->input('deducciones-claves');
        $totalDeds = 0;
        foreach ($deds as $key => $ded) {
            $totalDeds += $this->request->input('deducciones-importes')[$key];
        }

        $totalOtrosPagos = 0;
        if ($this->request->has('otros-pagos-claves')) {
            $otrosPagos = $this->request->input('otros-pagos-claves');
            foreach ($otrosPagos as $key => $otroPago) {
                $totalOtrosPagos += $this->request->input('otros-pagos-importes')[$key];
            }
        }

        $fechaInicioLaboral = new Carbon($this->request->input('fechaInicioLaboral'));
        $antiguedad = $fechaInicioLaboral->diffInDays(new Carbon($fechaFinalPago));
        $antiguedad = (int)floor(($antiguedad) / 7);
        $regimen = $this->request->input('regimen');

        $subTotal = $totalPers + $totalOtrosPagos;
        $total = $subTotal - $totalDeds;
        $valorUnitario = $totalPers + $totalOtrosPagos;
        $importe = $totalPers + $totalOtrosPagos;
        $sindicalizado = $this->request->has('sindicalizado') ? 'Sí' : 'No';
        $cerFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);
        $data = [
            '@attributes' => [
                'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd http://www.sat.gob.mx/cfd/ecb/ecb.xsd http://www.sat.gob.mx/nomina12 http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd',
                'xmlns:nomina12' => 'http://www.sat.gob.mx/nomina12',
                'xmlns:detallista' => 'http://www.sat.gob.mx/detallista',
                'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/3',
                'xmlns:implocal' => 'http://www.sat.gob.mx/implocal',
                'xmlns:notariospublicos' => 'http://www.sat.gob.mx/notariospublicos',
                'xmlns:pagos' => 'http://www.sat.gob.mx/pagos',
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                'version' => '3.3',
                'serie' => $serie,
                'folio' => $folio,
                'fecha' => $fechaFactura,
                'tipoDeComprobante' => 'egreso',
                'formaDePago' => 'PAGO EN UNA SOLA EXHIBICION',
                'metodoDePago' => 'NA',
                'noCertificado' => $cerFile->getNumeroCertificado(),
                'subTotal' => $subTotal,
                'total' => $total,
                'TipoCambio' => '1',
                'Moneda' => 'MXN',
                'descuento' => $totalDeds,
                'LugarExpedicion' => $codigoPostal,
                'certificado' => '',
                'sello' => '',
            ],
            'cfdi:Emisor' => [
                '@attributes' => [
                    'rfc' => $perfil->getRfc(),
                    'nombre' => $perfil->getRazonSocial(),
                ],
                'cfdi:RegimenFiscal' => [
                    '@attributes' => [
                        'Regimen' => $regimen,
                    ]
                ]
            ],
            'cfdi:Receptor' => [
                '@attributes' => [
                    'rfc' => $this->request->input('rfc'),
                    'nombre' => $this->request->input('nombre'),
                ],
            ],
            'cfdi:Conceptos' => [
                'cfdi:Concepto' => [
                    '@attributes' => [
                        'cantidad' => '1',
                        'unidad' => 'ACT',
                        'descripcion' => 'Pago de nómina',
                        'valorUnitario' => $valorUnitario,
                        'importe' => $importe,
                    ]
                ]
            ],
            'cfdi:Impuestos' => [
            ],
            'cfdi:Complemento' => [
                'nomina12:Nomina' => [
                    '@attributes' => [
                        'Version' => '1.2',
                        'FechaPago' => $fechaPago,
                        'FechaInicialPago' => $fechaInicialPago,
                        'FechaFinalPago' => $fechaFinalPago,
                        'NumDiasPagados' => $numDiasPagados,
                        'TipoNomina' => 'O',
                        'TotalDeducciones' => $totalDeds,
                        'TotalOtrosPagos' => $totalOtrosPagos,
                        'TotalPercepciones' => $totalPers,
                        'xmlns:nomina12' => 'http://www.sat.gob.mx/nomina12',
                    ],
                    'nomina12:Emisor' => [
                        '@attributes' => [
                            'RegistroPatronal' => $this->request->input('registroPatronal')
                        ],
                    ],
                    'nomina12:Receptor' => [
                        '@attributes' => [
                            'Curp' => $this->request->input('curp'),
                            'NumSeguridadSocial' => $this->request->input('numSeguroSocial'),
                            'FechaInicioRelLaboral' => $fechaInicioLaboral->format('Y-m-d'),
                            'Antiguedad' => "P{$antiguedad}W",
                            'TipoContrato' => $this->request->input('tipoContrato'),
                            'Sindicalizado' => $sindicalizado,
                            'TipoJornada' => $this->request->input('tipoJornada'),
                            'TipoRegimen' => $this->request->input('tipoRegimen'),
                            'NumEmpleado' => $this->request->input('numeroEmpleado'),
                            'RiesgoPuesto' => $this->request->input('riesgoPuesto'),
                            'PeriodicidadPago' => $this->request->input('periodicidadPago'),
                            'SalarioBaseCotApor' => $this->request->input('salario'),
                            'SalarioDiarioIntegrado' => $this->request->input('salarioDiarioIntegrado'),
                            'ClaveEntFed' => $this->request->input('estado'),                        ]
                    ],
                    'nomina12:Percepciones' => [
                        '@attributes' => [
                            'TotalGravado' => $totalGravados,
                            'TotalExento' => $totalExentos,
                            'TotalSueldos' => $totalSueldos,
                            'TotalJubilacionPensionRetiro' => $totalJubilacion,
                            'TotalSeparacionIndemnizacion' => $totalIndemnizacion,
                        ],
                        // 'nomina12:JubilacionPensionRetiro' => [\
                        //     '@attributes' => [\
                        //         'TotalUnaExhibicion' => '20000',\
                        //         // 'TotalParcialidad' => '',\
                        //         // 'MontoDiario' => '',\
                        //         'IngresoAcumulable' => '1000',\
                        //         'IngresoNoAcumulable' => '300',\
                        //     ]\
                        // ],\
                        // 'nomina12:SeparacionIndemnizacion' => [\
                        //     '@attributes' => [\
                        //         'TotalPagado' => '1000.00',\
                        //         'NumAñosServicio' => '1000.00',\
                        //         'UltimoSueldoMensOrd' => '1000.00',\
                        //         'IngresoAcumulable' => '500.00',\
                        //         'IngresoNoAcumulable' => '500.00',\
                        //     ]\
                        // ],
                    ],
                    'nomina12:Deducciones' => [
                        '@attributes' => [
                            'TotalOtrasDeducciones' => $totalDeds,
                        ],
                    ],
                ]
            ]
        ];

        $user = Auth::user();
        $keyFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::LLAVE);
        $cerFile = $user->getInfoFactura()->getDocumentByType(UsersInfoFacturaDocumentos::CERTIFICADO);

        $path = "uploads/users_documentos/";
        $xml = Array2XML::init($version='1.0', $encoding='UTF-8');
        $xml = Array2XML::createXML('cfdi:Comprobante', $data);
        $percepciones = $xml->getElementsByTagName('nomina12:Percepciones')[0];
        $deducciones = $xml->getElementsByTagName('nomina12:Deducciones')[0];
        $nomina = $xml->getElementsByTagName('nomina12:Nomina')[0];

        if ($this->request->has('sncf')) {
            $nominaEmisor = $xml->getElementsByTagName('nomina12:Emisor')[0];
            $sncfOrigen = $this->request->input('sncfOrigen');
            $sncfMonto = $this->request->input('sncfMonto');
            $sncf = $xml->createElement('nomina12:EntidadSNCF');
            $sncf->setAttribute('OrigenRecurso', $sncfOrigen);

            if ($sncfOrigen === 'IM') {
                $sncf->setAttribute('MontoRecursoPropio', $sncfMonto);
            }

            $nominaEmisor->appendChild($sncf);
        }

        if (!empty($this->request->input('clabe'))) {
            $nominaReceptor = $xml->getElementsByTagName('nomina12:Receptor')[0];
            $nominaReceptor->setAttribute('CuentaBancaria', $this->request->input('clabe'));
        } else {
            $nominaReceptor = $xml->getElementsByTagName('nomina12:Receptor')[0];
            $nominaReceptor->setAttribute('Banco', $this->request->input('banco'));
        }

        foreach ($pers as $key => $per) {
            $percepcion = $xml->createElement('nomina12:Percepcion');
            $percepcion->setAttribute('TipoPercepcion', $this->request->input('percepciones-tipos')[$key]);
            $percepcion->setAttribute('Clave', $this->request->input('percepciones-claves')[$key]);
            $percepcion->setAttribute('Concepto', $this->request->input('percepciones-conceptos')[$key]);
            $percepcion->setAttribute('ImporteGravado', $this->request->input('percepciones-gravados')[$key]);
            $percepcion->setAttribute('ImporteExento', $this->request->input('percepciones-excentos')[$key]);
            $percepciones->appendChild($percepcion);
        }

        foreach ($deds as $key => $ded) {
            $deduccion = $xml->createElement('nomina12:Deduccion');
            $deduccion->setAttribute('TipoDeduccion', $this->request->input('deducciones-tipos')[$key]);
            $deduccion->setAttribute('Clave', $this->request->input('deducciones-claves')[$key]);
            $deduccion->setAttribute('Concepto', $this->request->input('deducciones-conceptos')[$key]);
            $deduccion->setAttribute('Importe', $this->request->input('deducciones-importes')[$key]);
            $deducciones->appendChild($deduccion);
        }
        if ($this->request->has('otros-pagos-claves')) {
            $otrosPagos = $xml->createElement('nomina12:OtrosPagos');
            $nomina->appendChild($otrosPagos);
            foreach ($otrosPagos as $key => $otroPago) {
                $otroPago = $xml->createElement('nomina12:OtroPago');
                $otroPago->setAttribute('TipoOtroPago', $this->request->input('otro-pago-tipos')[$key]);
                $otroPago->setAttribute('Clave', $this->request->input('otro-pago-claves')[$key]);
                $otroPago->setAttribute('Concepto', $this->request->input('otro-pago-conceptos')[$key]);
                $otroPago->setAttribute('Importe', $this->request->input('otro-pago-importes')[$key]);
                $subsidio = $xml->createElement('nomina12:SubsidioAlEmpleo');
                $subsidio->setAttribute('SubsidioCausado', $this->request->input('otro-pago-subcidios')[$key]);
                $compensacion = $xml->createElement('nomina12:CompensacionSaldosAFavor');
                $compensacion->setAttribute('SaldoAFavor', $this->request->input('otro-pago-saldos')[$key]);
                $compensacion->setAttribute('Año', $this->request->input('otro-pago-anios')[$key]);
                $compensacion->setAttribute('RemanenteSalFav', $this->request->input('otro-pago-remanente')[$key]);

                $otroPago->appendChild($subsidio);
                $otroPago->appendChild($compensacion);
                $otrosPagos->appendChild($otroPago);
            }
        }

        $nombreKey = $keyFile->getName();
        $extKey = pathinfo($nombreKey, PATHINFO_EXTENSION);
        if ($extKey === 'key') {
            $nombreKey .= '.pem';
        }
        $params = [
            'xmlB64' => base64_encode($xml->saveXml()),
            'keyPEMB64' => base64_encode(file_get_contents($path . $nombreKey)),
        ];
        $response = Multipac::generateSello($params);
        // $doc = $this->sellarXML($xml->saveXML(), $path . $cerFile->getName(), $path . $nombreKey);\
        // dump($doc);die;
        // file_put_contents('uploads/prueba.xml', $doc);
        // $doc = (file_get_contents('uploads/nomina12_cliente_sin_timbre.xml'));
        // dump($doc);
        // $doc = file_get_contents('uploads/prueba.xml');
        // // $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
        // // $reemplazar=array("", "", "", "");
        // // $doc=str_ireplace($buscar,$reemplazar,$doc);
        // dump($doc);die;

        $domDoc = new \DomDocument();
        $domDoc->loadXML($xml->saveXml()) or die("XML invalido");
        $c = $domDoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
        $c->setAttribute('sello', $response->sello);
        $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($path . $cerFile->getName())));
        $c->setAttribute('certificado', $certificado);
        $doc = $domDoc->savexml();
//         dump($doc);die;
        $params = [
            'cfdiB64' => base64_encode($doc),
        ];

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
                $params = [
                    'xmlB64' => base64_encode($response->cfdiTimbrado),
                    'plantilla' => 'nomina',
                ];

                $pdfResponse = MultiPac::generatePDF($params);
                if ($pdfResponse->code === "210") {
                    $pdf = $pdfResponse->pdf;
                } else {
                    $pdf = $pdfResponse->message;
                }
                $nomina = new Nominas($user);
                $nomina->setUuid($response->uuid);
                $nomina->setXml($response->cfdiTimbrado);
                $nomina->setPdf($pdf);
                $nomina->setSolicitudTimbre($doc);
                $nomina->setEstatus(Nominas::TIMBRADA);

                foreach ($pers as $key => $per) {
                    $percepcion = new NominasPercepciones($nomina);
                    $percepcion->setCodigo($this->request->input('percepciones-tipos')[$key]);
                    $percepcion->setClave($this->request->input('percepciones-claves')[$key]);
                    $percepcion->setConcepto($this->request->input('percepciones-conceptos')[$key]);
                    $percepcion->setImporteGravado($this->request->input('percepciones-gravados')[$key]);
                    $percepcion->setImporteExcento($this->request->input('percepciones-excentos')[$key]);
                    $nomina->addPercepcione($percepcion);
                }
                foreach ($deds as $key => $ded) {
                    $deduccion = new NominasDeducciones($nomina);
                    $deduccion->setCodigo($this->request->input('deducciones-tipos')[$key]);
                    $deduccion->setClave($this->request->input('deducciones-claves')[$key]);
                    $deduccion->setConcepto($this->request->input('deducciones-conceptos')[$key]);
                    $deduccion->setImporte($this->request->input('deducciones-importes')[$key]);
                    $nomina->addDeduccione($deduccion);
                }
                if ($this->request->has('otros-pagos-claves')) {
                    foreach ($otrosPagos as $key => $otroPago) {
                        $otroPago = new NominasOtrosPagos($nomina);
                        $otroPago->setTipoOtroPago($this->request->input('otro-pago-tipos')[$key]);
                        $otroPago->setClave($this->request->input('otro-pago-clave')[$key]);
                        $otroPago->setConceptol($this->request->input('otro-pago-conceptos')[$key]);
                        $otroPago->setImporte($this->request->input('otro-pago-importes')[$key]);
                        $otroPago->setSubsidioCausado($this->request->input('otro-pago-subcidios')[$key]);
                        $otroPago->setSaldoFavor($this->request->input('otro-pago-saldos')[$key]);
                        $otroPago->setAnio($this->request->input('otro-pago-anios')[$key]);
                        $otroPago->setRemanente($this->request->input('otro-pago-remanente')[$key]);
                        $nomina->addOtrosPago($otroPago);
                    }
                }
                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();

                $f->setFolio($f->getFolio() + 1);
                $f->persist();

                $nomina->flush();

                Flash::success('Nomina generada correctamente');
                return redirect()->action('Users\NominasController@getIndex');
            break;
            default:
                Flash::error("Error generando la nomina Codigo: {$response->codRetorno} - Mensaje: {$response->msgRetorno}");
                return redirect()->action('Users\NominasController@getIndex');
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
        openssl_sign($cadena_original, $sig, $private);
        $sello = base64_encode($sig);
        $c = $xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
        $c->setAttribute('sello', $sello);
        $c->setAttribute('certificado', $certificado);
        return $xdoc->saveXML();
    }

    public function getCancelar($id) {
        $nomina = Nominas::find($id);

        if (!$nomina) {
            return redirect('/');
        }

        $user = Auth::user();

        if ($nomina->getUser()->getId() !== $user->getId()) {
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

        $key = file_get_contents("uploads/users_documentos/{$nombreKey}");
        $cer = file_get_contents("uploads/users_documentos/{$nombreCer}");

        $data = [
            'rfcEmisor' => $user->getPerfil()->getRfc(),
            'uuid' => $nomina->getUuid(),
            'keyPEM' => $key,
            'cerPEM' => $cer,
        ];

        $response = MultiPac::callMethodWithNameClaveAcceso('cancelarCFDI', $data);
        switch ($response->codRetorno) {
            case 201:

                $nomina->setAcuse($response->acuse);
                $nomina->setEstatus(Nominas::CANCELADA);

                $user->setTimbresDisponibles($user->getTimbresDisponibles() - 1);
                $user->persist();

                $nomina->flush();                

                Flash::success('Nomina cancelada correctamente');
                return redirect()->action('Users\NominasController@getIndex');
            break;
            default:
                Flash::error("<strong>Error cancelando la nomina:</strong> {$response->mensaje}");
                return redirect()->action('Users\NominasController@getIndex');
                // return redirect()->action('Users\FacturasController@getAdd')->withInput();
        }

    }

    public function getInvoice($id) {
        $nomina = Nominas::find($id);

        if (!$nomina) {
            return redirect('/');
        }

        $perfil = Auth::user()->getPerfil();
        return $this->render('users.nominas.invoice', compact('nomina', 'perfil'));
    }

    public function getXml($id) {
        $nomina = Nominas::find($id);

        if (!$nomina) {
            return redirect('/');
        }

        $document = new \DOMDocument($nomina->getXml());
        $document->loadXML($nomina->getXml());
        $comprobante = $document->getElementsByTagName('Comprobante')[0];

        $nom = "{$comprobante->getAttribute('serie')}{$comprobante->getAttribute('folio')} - {$nomina->getUuid()}";

        return response($nomina->getXml())
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'aplicaction/xml')
            ->header('Content-length', strlen($nomina->getXml()))
            ->header('Content-Disposition', 'attachment; filename=' . $nom . '.xml')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function getPdf($id) {
        $nomina = Nominas::find($id);

        if (!$nomina) {
            return redirect('/');
        }

        $document = new \DOMDocument($nomina->getXml());
        $document->loadXML($nomina->getXml());
        $comprobante = $document->getElementsByTagName('Comprobante')[0];

        $nom = "{$comprobante->getAttribute('serie')}{$comprobante->getAttribute('folio')} - {$nomina->getUuid()}";

        $fileContents = base64_decode($nomina->getPdf());

        return response($fileContents)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'aplicaction/pdf')
            ->header('Content-length', strlen($fileContents))
            ->header('Content-Disposition', 'attachment; filename=' . $nom . '.pdf')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function postEnvioEmail($id) {
        $nomina = Nominas::find($id);

        if (!$nomina) {
            return redirect('/');
        }

        $this->sendEmail($this->request->input('email'), $this->request->input('email'), 'Factura',
                'emails.nominas.nomina_enviada', [], [ "{$nomina->getUuid()}.xml" => $nomina->getXml(), "{$nomina->getUuid()}.pdf" => base64_decode($nomina->getPdf()) ]);

        Flash::success("Nomina enviada por correo electronico correctamente");
        return redirect()->action('Users\NominasController@getIndex');
    }

}
