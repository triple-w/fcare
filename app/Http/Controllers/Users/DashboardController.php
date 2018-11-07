<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Models\Folios;

use Auth;

class DashboardController extends Controller
{

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function getIndex() {
        $view = strtolower(Auth::user()->getRol());
        $folios = Auth::user()->getFolios();
        $foliosf = Folios::getDiffFolios(Auth::user(), \App\Models\Folios::getTiposFolio());
        return $this->render("dashboard.{$view}", [ 'folios' => $folios, 'foliosf' => $foliosf ]);
    }
}