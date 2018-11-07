<?php

namespace App\Http\Controllers\ReportarPagos;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ReportarPagos;

use Flash;

class ReportarPagosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('admin');
        parent::__construct($request);
    }

    public function getIndex() {
        $pagos = ReportarPagos::findAll();
        return $this->render('users.reportar_pagos.index_admin', [ 'pagos' => $pagos ]);
    }

    public function getIndexPendientes() {
        $pagos = ReportarPagos::findBy([ 'revisado' => false ]);
        return $this->render('users.reportar_pagos.index_pendientes_admin', [ 'pagos' => $pagos ]);
    }

    public function getView($id) {
        $pago = ReportarPagos::find($id);

        if (!$pago) {
            return redirect('/');
        }

        return $this->render('users.reportar_pagos.view_admin', compact('pago'));
    }

    public function getAprobarPago($id) {
        $pago = ReportarPagos::find($id);

        if (!$pago) {
            return redirect('/');
        }

        $pago->setRevisado(true);
        $pago->setAprobado(true);

        $pago->flush();

        Flash::success('Pago aprobado correctamente');
        return redirect()->action('ReportarPagos\ReportarPagosController@getIndexPendientes');
    }

    public function getNoAprobarPago($id) {
        return $this->render('users.reportar_pagos.no_aprobar');
    }

    public function postNoAprobarPago($id) {
        $pago = ReportarPagos::find($id);

        if (!$pago) {
            return redirect('/');
        }

        $pago->setRevisado(true);
        $pago->setAprobado(false);

        $pago->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        Flash::success('Pago No aprobado correctamente');
        return redirect()->action('ReportarPagos\ReportarPagosController@getIndexPendientes');
    }
}
