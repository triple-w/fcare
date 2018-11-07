<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Facturas;
use App\Models\Complementos;

use Excel;
use PDF;

use Flash;

class ReportesController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('user');
        parent::__construct($request);
    }

    public function getFacturas() {
        return $this->render('users.reportes.facturas');
    }

    public function postFacturas() {
        $request = $this->request->all();
        switch ($this->request->input('tipoCfdi')){
            case "FAC":
                $facturas = Facturas::getFacturas($request);
                $cant = count($facturas);
            break;
            case "COM":
                $complementos = Complementos::getComplementosReporte($request);
                $cant = count($complementos);
            break;
        }

        if (count($cant) === 0) {
            Flash::info('No existen registros para las fechas especificadas');
            return $this->render('users.reportes.facturas', compact('request'));
        }

        switch ($this->request->input('tipoReporte')) {
            case "EXCEL":
                if(isset($facturas)){
                    Excel::create('facturas', function($excel) use ($facturas) {
                        $excel->sheet('facturas', function($sheet) use ($facturas) {

                            $titulos = [ 'ID', 'CLIENTE', 'FECHA', 'TIPO COMPROBANTE', 'ESTADO', 'MONTO' ];
                            $sheet->appendRow($titulos);

                            $totalMonto = 0;
                            foreach ($facturas as $factura) {
                            $row = [];
                                $xml = new \DOMDocument();
                            $xml->loadXML($factura->getXml());
                            $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
                            $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
                            $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
                            $row[] = "{$serie} - {$folio}";
                            $row[] = "{$factura->getRfc()} - {$factura->getRazonSocial()}";
                            $row[] = !empty($factura->getFechaFactura()) ? $factura->getFechaFactura()->toFormattedDateString() : $factura->getFecha()->toFormattedDateString();
                            $strComprobante = $factura->getNombreComprobante();
                            if (!empty($strComprobante)) {
                            $row[] = constant("App\Models\Facturas::$strComprobante");
                            } else {
                                $row[] = '';
                            }
                                $row[] = $factura->getEstatus();
                                $monto = $factura->getMontoTotal();
                                $totalMonto += $monto;
                                $row[] = number_format((double)$monto, '2', '.', '');
                                $sheet->appendRow($row);
                            }

                            $row = [];
                            $row[] = '';
                            $row[] = '';
                            $row[] = '';
                            $row[] = 'Monto Total';
                            $row[] = number_format((double)$totalMonto, '2', '.', '');
                            $sheet->appendRow($row);

                            $row = [];
                            $row[] = '';
                            $row[] = '';
                            $row[] = '';
                            $row[] = 'Total De Facturas';
                            $row[] = count($facturas);
                            $sheet->appendRow($row);

                        });

                    })->download('xlsx');
                }elseif(isset($complementos)){
                    Excel::create('complementos', function($excel) use ($complementos) {
                        $excel->sheet('complementos', function($sheet) use ($complementos) {
    
                            $titulos = [ 'ID', 'CLIENTE', 'FECHA', 'TIPO COMPROBANTE', 'ESTADO', 'MONTO' ];
                            $sheet->appendRow($titulos);
    
                            $totalMonto = 0;
                            foreach ($complementos as $complemento) {
                                $row = [];
                                $xml = new \DOMDocument();
                                $xml->loadXML($complemento->getXml());
                                $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0];
                                $serie = empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie');
                                $folio = empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio');
                                $row[] = "{$serie} - {$folio}";
                                $row[] = "{$complemento->getRfc()} - {$complemento->getRazonSocial()}";
                                $row[] = !empty($complemento->getFecha()) ? $complemento->getFecha()->toFormattedDateString() : $complemento->getFecha()->toFormattedDateString();
                                $row[] = 'Complemento de Pago';
                                $row[] = $complemento->getEstatus();
                                $monto = $complemento->getMontoTotal();
                                $totalMonto += $monto;
                                $row[] = number_format((double)$monto, '2', '.', '');
                                $sheet->appendRow($row);
                            }
    
                            $row = [];
                            $row[] = '';
                            $row[] = '';
                            $row[] = '';
                            $row[] = 'Monto Total';
                            $row[] = number_format((double)$totalMonto, '2', '.', '');
                            $sheet->appendRow($row);
    
                            $row = [];
                            $row[] = '';
                            $row[] = '';
                            $row[] = '';
                            $row[] = 'Total De Complementos';
                            $row[] = count($complementos);
                            $sheet->appendRow($row);
    
                        });
    
                    })->download('xlsx');
                }

            return;
            break;
            case "PDF":
                if(isset($facturas)){
                    $pdf = PDF::loadView('pdfs.reportes.facturas', compact("facturas"));
                    return $pdf->download('facturas.pdf');
                } elseif (isset($complementos)){
                    $pdf = PDF::loadView('pdfs.reportes.complementos', compact("complementos"));
                    return $pdf->download('complementos.pdf');
                }
            break;
        }

        return $this->render('users.reportes.facturas', compact('facturas', 'complementos', 'request'));
    }

}
