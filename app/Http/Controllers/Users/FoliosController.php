<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Folios;

use Flash;
use Auth;

class FoliosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('folios.diff', [ 'only' => [
            'getAdd',
            'postAdd',
        ]]);
        parent::__construct($request);
    }

    public function getIndex() {
        $folios = Auth::user()->getFolios();
        return $this->render('users.folios.index', [ 'folios' => $folios ]);
    }

    public function getAdd() {
        return $this->render('users.folios.add');
    }

    public function postAdd() {

        $folios = Auth::user()->getFolios();

        $arrFolios = [];
        foreach ($folios as $folio) {
            $arrFolios[$folio->getTipo()] = $folio->getSerie();
        }
        if (array_key_exists($this->request->input('tipo'), $arrFolios)) {
            Flash::error('Ya se tiene registrado este tipo de folio para este usuario');
            return redirect()->action('Users\FoliosController@getIndex');
        }

        $folio = new Folios(Auth::user());

        $folio->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        Flash::success('Registro agregado correctamente');
        return redirect()->action('Users\FoliosController@getIndex');
    }

    public function getEdit($id) {
        $folio = Folios::find($id);

        if (!$folio) {
            return redirect('/');
        }

        return $this->render('users.folios.edit', [ 'folio' => $folio ]);
    }

    public function postEdit($id) {
        $folio = Folios::find($id);

        if (!$folio) {
            return redirect('/');
        }

        $folio->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        Flash::success('Registro editado correctamente');
        return redirect()->action('Users\FoliosController@getIndex');
    }

    public function getDelete($id) {
        $folio = Folios::find($id);

        if (!$folio) {
            return redirect('/');
        }

        $folio->remove();

        Flash::success('Registro eliminado correctamente');
        return redirect()->action('Users\FoliosController@getIndex');
    }

}
