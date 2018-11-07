<?php

namespace App\Extensions\MultiPac;

use Carbon\Carbon;

use SoapClient;

use App;
use Log;
use SimpleXMLElement;
use LSS\Array2XML;

class MultiPac {

    private $client;
    private $clientNomina;
    private $clientTools;
    private $clientToolsV33;

    private $usuario;
    private $usuarioNomina;
    private $usuarioTools;

    private $password;
    private $passwordNomina;
    private $passwordTools;

    public function __construct() {
        $env = env('APP_ENV');
        switch ($env) {
            case 'local':
                $this->client = new SoapClient("http://facturaloplus.com/ws/pruebas.php?wsdl");
                $this->clientNomina = new SoapClient("http://facturaloplus.com/pruebas/system/ws/ws.facturaplus.php?wsdl", [ 'trace' => true ]);
                $this->clientTools = new SoapClient("http://facturaloplus.com/ws/WSTools.php?wsdl", [ 'trace' => true ]);
                $this->clientToolsV33 = new SoapClient("http://facturaloplus.com/ws/WSTools33.php?wsdl", [ 'trace' => true ]);
                $this->usuario = 'AAA010101AAA';
                $this->usuarioTools = 'pruebas';
                $this->password = '12345678a';
                $this->passwordTools = '12345678a';
            break;
            case 'test':
                $this->client = new SoapClient("http://facturaloplus.com/ws/pruebas.php?wsdl");
                $this->clientNomina = new SoapClient("http://facturaloplus.com/pruebas/system/ws/ws.facturaplus.php?wsdl", [ 'trace' => true ]);
                $this->clientTools = new SoapClient("http://facturaloplus.com/ws/WSTools.php?wsdl", [ 'trace' => true ]);
                $this->clientToolsV33 = new SoapClient("http://facturaloplus.com/ws/WSTools33.php?wsdl", [ 'trace' => true ]);
                $this->usuario = 'AAA010101AAA';
                $this->usuarioTools = 'pruebas';
                $this->password = '12345678a';
                $this->passwordTools = '12345678a';
            break;
            case 'production':
                $this->client = new SoapClient("http://facturaloplus.com/ws/produccionWS.php?wsdl");
                $this->clientNomina = new SoapClient("http://facturaloplus.com/app33/system/ws/ws.facturaplus.php?wsdl", [ 'trace' => true ]);
                $this->clientTools = new SoapClient("http://facturaloplus.com/ws/WSTools.php?wsdl", [ 'trace' => true ]);
                $this->clientToolsV33 = new SoapClient("http://facturaloplus.com/ws/WSTools33.php?wsdl", [ 'trace' => true ]);
                $this->usuario = 'CCA1510307X6';
                $this->usuarioTools = 'pruebas';
                $this->password = 'cKy1uaCvTKCB';
                $this->passwordTools = '12345678a';
            break;
        }
    }

    public function callMethod($method, $data = []) {
        $params = [
            'usuario' => $this->usuario,
            'password' => $this->password,
        ];

        $params += $data;
        return $this->client->__soapCall($method, $params);
    }

    public function callMethodWithNameClaveAcceso($method, $data = []) {
        $params = [
            'usuario' => $this->usuario,
            'claveAcceso' => $this->password,
        ];
        $params += $data;

        return $this->clientNomina->__soapCall($method, $params);
    }

    public function callTimbrarCFDI($data) {
        $params = [
            'usuario' => $this->usuario,
            'claveAcceso' => $this->password,
        ];
        $params += $data;

        try {
            return $this->clientNomina->timbrarCFDI($params['usuario'], $params['claveAcceso'], $params['cfdiB64']);
        } catch (\SoapFault $ex) {
            return $this->clientNomina->__getLastResponse();
        }
    }

    public function generatePDF($data) {
        $params = [
            'usuario' => $this->usuarioTools,
            'claveAcceso' => $this->passwordTools,
        ];
        $params += $data;

        try {
            return $this->clientTools->generarPDF($params['usuario'], $params['claveAcceso'], $params['xmlB64'], $params['plantilla']);
        } catch (\SoapFault $ex) {
            return $this->clientTools->__getLastResponse();
        }
    }

    public function generatePDFV33($data) {
        $params = [
            'usuario' => $this->usuarioTools,
            'claveAcceso' => $this->passwordTools,
        ];
        $params += $data;

        try {
            return $this->clientToolsV33->generarPDF($params['usuario'], $params['claveAcceso'], $params['xmlB64'], $params['plantilla'], $params['json'], $params['logo']);
        } catch (\SoapFault $ex) {
            return $this->clientTools->__getLastResponse();
        }
    }

    public function generateSello($data) {
        $params = [
            'usuario' => $this->usuarioTools,
            'claveAcceso' => $this->passwordTools,
        ];
        $params += $data;

        try {
            return $this->clientTools->generarSello($params['usuario'], $params['claveAcceso'], $params['xmlB64'], $params['keyPEMB64']);
        } catch (\SoapFault $ex) {
            return $this->clientTools->__getLastResponse();
        }
    }

    public function generateSelloV33($data) {
        $params = [
            'usuario' => $this->usuarioTools,
            'claveAcceso' => $this->passwordTools,
        ];
        $params += $data;

        try {
            return $this->clientToolsV33->generarSello($params['usuario'], $params['claveAcceso'], $params['xmlB64'], $params['keyPEMB64']);
        } catch (\SoapFault $ex) {
            return $this->clientTools->__getLastResponse();
        }
    }

    public function generarFacturaWhitData($user, $userFactura, $data) {
        $cerFile = $user->getInfoFactura()->getDocumentByType(App\Models\UsersInfoFacturaDocumentos::CERTIFICADO);

        $fechaFactura = new Carbon();
        $diasDiferencia = $fechaFactura->diffInDays(Carbon::now());
        if ($diasDiferencia > 3) {
            Flash::error('Factura fuera de fecha');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

        $tipoDocumento = strtolower(App\Models\Facturas::getTipoDocumento('FACTURA'));
        $f = $user->getFolioByTipo(App\Models\Facturas::getTipoDocumento('FACTURA'));
        if (empty($f)) {
            Flash::error('No existe un folio configurado para ese tipo de Documento');
            return redirect()->action('Users\FacturasV33Controller@getIndex');
        }

        $serie = $f->getSerie();
        $folio = $f->getFolio();
        $fechaFactura = $fechaFactura->format('Y-m-d\TH:i:s');
        $noCertificado = $cerFile->getNumeroCertificado();
        $moneda = 'MXN';
        $tipoComprobante = 'I';
        $formaPago = '04';
        // $formaPago = '01';
        $metodoPago = 'PUE';
        // $metodoPago = 'PUE';
        $tipoCambio = '1.0';
        $usoCFDI = 'G03';
        // $usoCFDI = 'G01';
        $perfil = $user->getPerfil();
        $lugarExpedicion = $perfil->getCodigoPostal();

        $dataXml = [
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
                    // 'RegimenFiscal' => "601",
                    'RegimenFiscal' => $perfil->getNumeroRegimen(),
                ],
            ],
            'cfdi:Receptor' => [
                '@attributes' => [
                    'Rfc' => $userFactura->getPerfil()->getRfc(),
                    'Nombre' => $userFactura->getPerfil()->getRazonSocial(),
                    'UsoCFDI' => $usoCFDI,
                ],
            ],
            'cfdi:Conceptos' => [
            ],
            'cfdi:Impuestos' => [
                '@attributes' => [
                    'TotalImpuestosRetenidos' => '',
                    'TotalImpuestosTrasladados' => '',
                ],
            ],
        ];

        $xml = Array2XML::createXML('cfdi:Comprobante', $dataXml);
        $conceptos = $xml->getElementsByTagName('cfdi:Conceptos')[0];

        foreach ($data['conceptos'] as $conceptoData) {
            $concepto = $xml->createElement('cfdi:Concepto');

            $impuestos = $xml->createElement('cfdi:Impuestos');
            $retenciones = $xml->createElement('cfdi:Retenciones');
            $traslados = $xml->createElement('cfdi:Traslados');

            $concepto->setAttribute('ClaveProdServ', $conceptoData['ClaveProdServ']);
            $concepto->setAttribute('ClaveUnidad', $conceptoData['ClaveUnidad']);
            $concepto->setAttribute('NoIdentificacion', $conceptoData['NoIdentificacion']);
            $concepto->setAttribute('Cantidad', $conceptoData['Cantidad']);
            $concepto->setAttribute('Unidad', $conceptoData['Unidad']);
            $concepto->setAttribute('Descripcion', $conceptoData['Descripcion']);
            $concepto->setAttribute('ValorUnitario', $conceptoData['ValorUnitario']);
            $concepto->setAttribute('Importe', $conceptoData['Importe']);
            $concepto->setAttribute('Descuento', $conceptoData['Descuento']);

            foreach ($conceptoData['ImpuestosTrasladados'] as $trasladoData) {
                $traslado = $xml->createElement('cfdi:Traslado');
                $traslado->setAttribute('Base', $trasladoData['Base']);
                $traslado->setAttribute('Impuesto', $trasladoData['Impuesto']);
                $traslado->setAttribute('TipoFactor', 'Tasa');
                $traslado->setAttribute('TasaOCuota', $trasladoData['TasaOCuota']);
                $traslado->setAttribute('Importe', $trasladoData['Importe']);
                $traslados->appendChild($traslado);
            }

            if ($traslados->childNodes->length > 0) {
                $impuestos->appendchild($traslados);
            }
            if ($impuestos->childNodes->length > 0) {
                $concepto->appendChild($impuestos);
            }

            $conceptos->appendchild($concepto);
        }

        $comprobante = $xml->getElementsByTagName('cfdi:Comprobante')[0];
        $comprobante->setAttribute('Total', $data['Total']);
        $comprobante->setAttribute('SubTotal', $data['SubTotal']);
        $comprobante->setAttribute('Descuento', $data['Descuento']);

        $impuestosSuma = $xml->getElementsByTagName('cfdi:Impuestos')[($xml->getElementsByTagName('cfdi:Impuestos')->length) - 1];
        $impuestosSuma->setAttribute('TotalImpuestosRetenidos', $data['TotalImpuestosRetenidos']);
        $impuestosSuma->setAttribute('TotalImpuestosTrasladados', $data['TotalImpuestosTrasladados']);

        $retencionesSuma = $xml->createElement('cfdi:Retenciones');
        $trasladosSuma = $xml->createElement('cfdi:Traslados');

        foreach ($data['trasladosSuma'] as $trasladoSumaData) {
            $trasladoSuma = $xml->createElement('cfdi:Traslado');
            $trasladoSuma->setAttribute('Impuesto', $trasladoSumaData['Impuesto']);
            $trasladoSuma->setAttribute('TipoFactor', $trasladoSumaData['TipoFactor']);
            $trasladoSuma->setAttribute('TasaOCuota', $trasladoSumaData['TasaOCuota']);
            $trasladoSuma->setAttribute('Importe', $trasladoSumaData['Importe']);
            $trasladosSuma->appendChild($trasladoSuma);
        }

        if ($trasladosSuma->childNodes->length > 0) {
            $impuestosSuma->appendChild($trasladosSuma);
        }

        $keyFile = $user->getInfoFactura()->getDocumentByType(\App\Models\UsersInfoFacturaDocumentos::LLAVE);
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

        $response = self::generateSelloV33($params);
        // $doc = $this->sellarXML($xml->saveXML(), $path . $cerFile->getName(), $path . $nombreKey);\
        // dump(base64_encode($doc), $doc);die;
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

        $response = self::callTimbrarCFDI($params);
        if (is_string($response)) {
            return false;
        }

        switch ($response->codRetorno) {
            case 200:
                $logo = 'null';
                if (!empty($user->getLogo()) && file_exists('uploads/users_logos/thumbnails/' . $user->getLogo()->getName())) {
                    $logo = base64_encode(file_get_contents('uploads/users_logos/thumbnails/' . $user->getLogo()->getName()));
                }
                $params = [
                    'xmlB64' => base64_encode($response->cfdiTimbrado),
                    'plantilla' => 1,
                    'json' => 'null',
                    'logo' => base64_encode(file_get_contents('uploads/users_logos/thumbnails/' . $user->getLogo()->getName())),
                ];

                $attachments = [];
                $pdfResponse = self::generatePDFV33($params);
                if ($pdfResponse->code === "210") {
                    $pdf = $pdfResponse->pdf;
                    $attachments["{$response->uuid}.pdf"] = base64_decode($pdf);
                }

                $attachments = [ "{$response->uuid}.xml" => $response->cfdiTimbrado ];
                $dataEmail = [];
                $email = $data['email'];
                $title = 'Factura generada';
                \Mail::send('emails.facturacion.factura_generada', $dataEmail, function($message) use ($email, $title, $attachments) {
                    $message->from('info@easytaxes.com', 'EASYTAXES');
                    $message->subject($title);
                    $message->to($email, $email);
                    foreach ($attachments as $nameFile => $attach) {
                        $message->attachData($attach, $nameFile);
                    }
                });
                return [ 'xml' => $response->cfdiTimbrado ];
                break;
            default:
                return false;
        }
    }
}

?>
