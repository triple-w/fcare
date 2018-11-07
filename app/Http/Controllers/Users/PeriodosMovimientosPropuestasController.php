<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\UsersPeriodosTerminados;
use App\Models\UsersPropuestas;
use App\Models\UsersPropuestasDocumentos;

use Auth;
use Flash;

class PeriodosMovimientosPropuestasController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('admin', [ 'only' => [
            'getAdd',
            'postAdd',
            'getIndexAdmin',
            'getViewAdmin',
        ]]);
        parent::__construct($request);
    }

    public function getIndex() {
        $propuestas = Auth::user()->getPropuestas();
        return $this->render('users.propuestas.index', compact('propuestas'));
    }

    public function getIndexAdmin($id) {
        $propuestas = UsersPropuestas::findBy([ 'user' => $id ]);
        return $this->render('users.propuestas.index_admin' , compact('propuestas'));
    }

    public function getView($id) {
        $propuesta = UsersPropuestas::find($id);
        return $this->render('users.propuestas.view', compact('propuesta'));
    }

    public function getViewAdmin($id) {
        $propuesta = UsersPropuestas::find($id);
        return $this->render('users.propuestas.view_admin', compact('propuesta'));
    }

    public function getAdd($id, $anio, $mes, $idTerminado) {
        return $this->render('users.propuestas.add');
    }

    public function postAdd($id, $anio, $mes, $idTerminado) {
        $periodoTerminado = UsersPeriodosTerminados::find($idTerminado);
        $periodoTerminado->setRevisado(true);
        $periodoTerminado->persist();

        $user = Users::find($id);
        $propuesta = new UsersPropuestas($user);
        $propuesta->setMes($mes);
        $propuesta->setAnio($anio);

        for($i=0; $i<count($_FILES['docs']['name']); $i++) {
            $file = array(
                "name" => $_FILES['docs']['name'][$i],
                "type" => $_FILES['docs']['type'][$i],
                "tmp_name" => $_FILES['docs']['tmp_name'][$i],
                "error" => $_FILES['docs']['error'][$i],
                "size" => $_FILES['docs']['size'][$i]
            );

            if (!empty($file['name'])) {
                $documento = new UsersPropuestasDocumentos($propuesta);
                $documento->setEntityFile(public_path("uploads/propuestas_documentos/"), $file);
                $propuesta->addDocumento($documento);
            }
        }

        $propuesta->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        Flash::success('Propuesta enviada correctamente');
        return redirect()->action('PeriodosTerminados\PeriodosTerminadosController@getIndex');
    }
}