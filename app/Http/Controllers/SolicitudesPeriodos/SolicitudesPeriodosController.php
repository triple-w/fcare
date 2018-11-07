<?php

namespace App\Http\Controllers\SolicitudesPeriodos;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UsersSolicitudesPeriodos;

use Auth;
use Flash;

class SolicitudesPeriodosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('admin');
        parent::__construct($request);
    }

    public function getIndex() {
        $solicitudesPeriodos = UsersSolicitudesPeriodos::findBy([ 'revisado' => false ]);
        return $this->render('solicitudes_periodos.index', compact('solicitudesPeriodos'));
    }

    public function getSolicitudRevisada($id) {
        $solicitudPeriodo = UsersSolicitudesPeriodos::find($id);

        $solicitudPeriodo->setRevisado(true);
        $solicitudPeriodo->flush();

        Flash::success('Registro actualizado correctamente');
        return redirect()->action('SolicitudesPeriodos\SolicitudesPeriodosController@getIndex');
    }
}
