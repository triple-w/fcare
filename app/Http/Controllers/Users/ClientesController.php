<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Clientes;

use Auth;
use Flash;

class ClientesController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('user');
        parent::__construct($request);
    }

    public function getInfo($id) {
        $cliente = Clientes::find($id);

        return $this->JSONResponse($cliente->toArray(null, [ 'relationships' => false ]));
    }

    public function getIndex() {
        $clientes = Clientes::findBy([ 'user' => Auth::user() ]);
        if ($this->request->ajax()) {
            $clientesArr = [];
            foreach ($clientes as $cliente) {
                $clientesArr[] = $cliente->toArray();
            }
            return $this->JSONResponse($clientesArr);
        }
        return $this->render('users.clientes.index', [ 'clientes' => $clientes ]);
    }

    public function getAdd() {
        return $this->render('users.clientes.add');
    }

    public function postAdd() {
        $cliente = new Clientes(Auth::user());

        $cliente->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        if ($this->request->ajax()) {
            return $this->JSONResponse();
        }

        Flash::success('Cliente agregado correctamente');
        return redirect()->action('Users\ClientesController@getIndex');
    }

    public function getEdit($id) {
        $cliente = Clientes::find($id);

        if (!$cliente) {
            return redirect('/');
        }

        return $this->render('users.clientes.edit', [ 'cliente' => $cliente ]);
    }

    public function postEdit($id) {
        $cliente = Clientes::find($id);

        if (!$cliente) {
            return redirect('/');
        }

        $cliente->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        if ($this->request->ajax()) {
            return $this->JSONResponse();
        }

        Flash::success('Cliente editado correctamente');
        return redirect()->action('Users\ClientesController@getIndex');
    }

    public function getDelete($id) {
        $cliente = Clientes::find($id);

        if (!$cliente) {
            return redirect('/');
        }

        $cliente->remove();

        Flash::success('Cliente eliminado correctamente');
        return redirect()->action('Users\ClientesController@getIndex'); 
    }

}