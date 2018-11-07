<?php

namespace App\Http\Controllers\PeriodosTerminados;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UsersPeriodosTerminados;

use Auth;
use Flash;

class PeriodosTerminadosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('admin');
        parent::__construct($request);
    }

    public function getIndex() {
        $periodosTerminados = UsersPeriodosTerminados::getPeriodos();
        return $this->render('periodos_terminados.index', compact('periodosTerminados'));
    }
}
