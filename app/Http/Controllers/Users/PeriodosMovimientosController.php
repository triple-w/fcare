<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\UsersPeriodos;
use App\Models\UsersPeriodosDocumentos;
use App\Models\UsersPeriodosDocumentosPagos;

use Carbon\Carbon;

use Auth;
use Zipper;
use Excel;

class PeriodosMovimientosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('admin', [ 'only' => [
            'getBusquedaAdmin',
            'postBusquedaAdmin',
            'getMovimientos',
            'getDownloadZip',
        ]]);
        parent::__construct($request);
    }

    public function getBusqueda() {
        $user = Auth::user();
        $now = Carbon::now();
        $emitidos = UsersPeriodosDocumentosPagos::getMovimientosEmitidos($now->month, $now->year, $user);
        $recibidos = UsersPeriodosDocumentosPagos::getMovimientosRecibidos($now->month, $now->year, $user);
        $totalEmitidos = 0;
        $totalRecibidos = 0;
        foreach ($emitidos as $emitido) {
            $totalEmitidos += $emitido->getMonto();
        }
        foreach ($recibidos as $recibido) {
            $totalRecibidos += $recibido->getMonto();
        }

        return $this->render('users.periodos_movimientos.busqueda', compact('totalEmitidos', 'totalRecibidos'));
    }

    public function postBusqueda() {
        $user = Auth::user();
        $now = Carbon::now();
        $mes = $this->request->input('mes');
        $anio = $this->request->input('anio');

        $emitidos = UsersPeriodosDocumentosPagos::getMovimientosEmitidos($mes, $anio, $user);
        $recibidos = UsersPeriodosDocumentosPagos::getMovimientosRecibidos($mes, $anio, $user);
        $totalEmitidos = 0;
        $totalRecibidos = 0;
        foreach ($emitidos as $emitido) {
            $totalEmitidos += $emitido->getMonto();
        }
        foreach ($recibidos as $recibido) {
            $totalRecibidos += $recibido->getMonto();
        }

        $emitidos = UsersPeriodosDocumentosPagos::getMovimientosEmitidos($mes, $anio, Auth::user());
        $recibidos = UsersPeriodosDocumentosPagos::getMovimientosRecibidos($mes, $anio, Auth::user());
        return $this->render('users.periodos_movimientos.busqueda', compact('emitidos', 'recibidos', 'totalEmitidos', 'totalRecibidos'));
    }

    public function getBusquedaAdmin($id) {
        return $this->render('users.periodos_movimientos.busqueda_admin');
    }

    public function postBusquedaAdmin($id) {
        $request = $this->request->all();
        $user = Users::find($id);
        $movimientos = UsersPeriodosDocumentosPagos::getMovimientos($this->request->input('mes'), $this->request->input('anio'), $user);
        return $this->render('users.periodos_movimientos.busqueda_admin', compact('movimientos', 'user', 'request'));
    }

    public function getMovimientos($id, $mes, $anio) {
        $user = Users::find($id);
        $emitidos = UsersPeriodosDocumentosPagos::getMovimientosEmitidos($mes, $anio, $user);
        $recibidos = UsersPeriodosDocumentosPagos::getMovimientosRecibidos($mes, $anio, $user);
        $totalEmitidos = 0;
        $totalRecibidos = 0;
        $ingresoSinFactura = 0;
        $periodos = UsersPeriodos::findBy([ 'anio' => $anio, 'mes' => $mes ]);
        foreach ($periodos as $periodo) {
            $ingresoSinFactura += $periodo->getIngresoSinFactura();
        }
        foreach ($emitidos as $emitido) {
            $totalEmitidos += $emitido->getMonto();
        }
        foreach ($recibidos as $recibido) {
            $totalRecibidos += $recibido->getMonto();
        }

        $emitidos = UsersPeriodosDocumentosPagos::getMovimientosEmitidos($mes, $anio, $user);
        $recibidos = UsersPeriodosDocumentosPagos::getMovimientosRecibidos($mes, $anio, $user);
        return $this->render('users.periodos_movimientos.movimientos', compact('emitidos', 'recibidos', 'user', 'mes', 'anio', 'totalEmitidos', 'totalRecibidos', 'periodos', 'ingresoSinFactura'));
    }

    public function getExportExcel($id, $mes, $anio) {
        $user = Users::find($id);
        $emitidos = UsersPeriodosDocumentosPagos::getMovimientosEmitidos($mes, $anio, $user);
        $recibidos = UsersPeriodosDocumentosPagos::getMovimientosRecibidos($mes, $anio, $user);
        Excel::create('movimientos', function($excel) use ($emitidos, $recibidos) {

            $excel->sheet('emitidos', function($sheet) use ($emitidos) {

                $titulos = [ 'TIPO', 'UUID', 'RFC Emisor', 'RFC Receptor', 'Retencion IVA', 'Retencion ISR', 'Traslado IVA', 'Tralsado IEPS', 'Monto Pagado', 'Deduccion', 'Tipo de Gasto', 'Clasificacion', 'Monto Factura', 'Concepto' ];
                $sheet->appendRow($titulos);

                foreach ($emitidos as $movimiento) {
                    $row = [];
                    $row[] = $movimiento->getDocumento()->getTipo();
                    $row[] = $movimiento->getDocumento()->getDatos()['uuid'];
                    $row[] = $movimiento->getDocumento()->getRfcEmisor();
                    $row[] = $movimiento->getDocumento()->getRfcReceptor();

                    $montoTotal = str_replace(',', '', substr($movimiento->getDocumento()->getDatos()['total'], 1));

                    $retenciones = $movimiento->getDocumento()->getRetenciones();
                    $retencionIVA = 0;
                    foreach ($retenciones as $retencion) {
                        if ($retencion['impuesto'] === 'IVA' || $retencion['impuesto'] === '002') {
                            $rtIVA = ($movimiento->getMonto() * $retencion['importe']) / $montoTotal;
                            $retencionIVA += $rtIVA;
                        }
                    }
                    $row[] = number_format($retencionIVA, 2, '.', '');

                    $retencionISR = 0;
                    foreach ($retenciones as $retencion) {
                        if ($retencion['impuesto'] === 'ISR' || $retencion['impuesto'] === '001') {
                            $rtISR = ($movimiento->getMonto() * $retencion['importe']) / $montoTotal;
                            $retencionISR += $rtISR;
                        }
                    }
                    $row[] = number_format($retencionISR, 2, '.', '');

                    $traslados = $movimiento->getDocumento()->getTraslados();
                    $trasladoIVA = 0;
                    foreach ($traslados as $traslado) {
                        if ($traslado['impuesto'] === 'IVA' || $traslado['impuesto'] === '002') {
                            $trIVA = ($movimiento->getMonto() * $traslado['importe']) / $montoTotal;
                            $trasladoIVA += $trIVA;
                        }
                    }
                    $row[] = number_format($trasladoIVA, 2, '.', '');

                    $trasladoIEPS = 0;
                    foreach ($traslados as $traslado) {
                        if ($traslado['impuesto'] === 'IEPS' || $traslado['impuesto'] == '003') {
                            $trIEPS = ($movimiento->getMonto() * $traslado['importe']) / $montoTotal;
                            $trasladoIVA += $trIEPS;
                        }
                    }
                    $row[] = number_format($trasladoIEPS, 2, '.', '');

                    $row[] = number_format($movimiento->getMonto(), 2, '.', ',');
                    $row[] = $movimiento->getDeduccion();
                    $row[] = $movimiento->getTipoGasto();
                    $row[] = $movimiento->getClasificacion();
                    $row[] = number_format($montoTotal, 2, '.', '');

                    $xml = new \DOMDocument();
                    $xml->loadXml($movimiento->getDocumento()->getXml());
                    $concepto = $xml->getElementsByTagName('Concepto')[0];
                    $row[] = empty($concepto->getAttribute('descripcion')) ? $concepto->getAttribute('Descripcion') : $concepto->getAttribute('descripcion');

                    $sheet->appendRow($row);
                }
            });

            $excel->sheet('recibidos', function($sheet) use ($recibidos) {

                $titulos = [ 'TIPO', 'UUID', 'RFC Emisor', 'RFC Receptor', 'Retencion IVA', 'Retencion ISR', 'Traslado IVA', 'Tralsado IEPS', 'Monto Pagado', 'Deduccion', 'Tipo de Gasto', 'Clasificacion', 'Monto Factura', 'Concepto' ];
                $sheet->appendRow($titulos);

                foreach ($recibidos as $movimiento) {
                    $row = [];
                    $row[] = $movimiento->getDocumento()->getTipo();
                    $row[] = $movimiento->getDocumento()->getDatos()['uuid'];
                    $row[] = $movimiento->getDocumento()->getRfcEmisor();
                    $row[] = $movimiento->getDocumento()->getRfcReceptor();

                    $montoTotal = str_replace(',', '', substr($movimiento->getDocumento()->getDatos()['total'], 1));

                    $retenciones = $movimiento->getDocumento()->getRetenciones();
                    $retencionIVA = 0;
                    foreach ($retenciones as $retencion) {
                        if ($retencion['impuesto'] === 'IVA' || $retencion['impuesto'] === '002') {
                            $rtIVA = ($movimiento->getMonto() * $retencion['importe']) / $montoTotal;
                            $retencionIVA += $rtIVA;
                        }
                    }
                    $row[] = number_format($retencionIVA, 2, '.', '');

                    $retencionISR = 0;
                    foreach ($retenciones as $retencion) {
                        if ($retencion['impuesto'] === 'ISR' || $retencion['impuesto'] === '001') {
                            $rtISR = ($movimiento->getMonto() * $retencion['importe']) / $montoTotal;
                            $retencionISR += $rtISR;
                        }
                    }
                    $row[] = number_format($retencionISR, 2, '.', '');

                    $traslados = $movimiento->getDocumento()->getTraslados();
                    $trasladoIVA = 0;
                    foreach ($traslados as $traslado) {
                        if ($traslado['impuesto'] === 'IVA' || $traslado['impuesto'] === '002') {
                            $trIVA = ($movimiento->getMonto() * $traslado['importe']) / $montoTotal;
                            $trasladoIVA += $trIVA;
                        }
                    }
                    $row[] = number_format($trasladoIVA, 2, '.', '');

                    $trasladoIEPS = 0;
                    foreach ($traslados as $traslado) {
                        if ($traslado['impuesto'] === 'IEPS' || $traslado['impuesto'] === '003') {
                            $trIEPS = ($movimiento->getMonto() * $traslado['importe']) / $montoTotal;
                            $trasladoIVA += $trIEPS;
                        }
                    }
                    $row[] = number_format($trasladoIEPS, 2, '.', '');

                    $row[] = number_format($movimiento->getMonto(), 2, '.', ',');
                    $row[] = $movimiento->getDeduccion();
                    $row[] = $movimiento->getTipoGasto();
                    $row[] = $movimiento->getClasificacion();
                    $row[] = number_format($montoTotal, 2, '.', '');

                    $xml = new \DOMDocument();
                    $xml->loadXml($movimiento->getDocumento()->getXml());
                    $concepto = $xml->getElementsByTagName('Concepto')[0];
                    $row[] = empty($concepto->getAttribute('descripcion')) ? $concepto->getAttribute('Descripcion') : $concepto->getAttribute('descripcion');

                    $sheet->appendRow($row);
                }
            });
        })->download('xlsx');
    }

    public function getDownloadZip($mes, $anio, $idUser) {
        $user = Users::find($idUser);
        $movimientos = UsersPeriodosDocumentos::getMovimientos($mes, $anio, $user);

        $nameZip = $user->getUsername() . '_' . time() . ".zip";
        $zip = Zipper::make($nameZip);
        foreach ($movimientos as $movimiento) {
            $zip->addString("{$movimiento->getDatos()['uuid']}.xml", $movimiento->getXml());
        }
        $zip->close();

        return response()->download($nameZip)->deleteFileAfterSend(true);
    }

}