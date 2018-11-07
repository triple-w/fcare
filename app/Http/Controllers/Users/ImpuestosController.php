<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Impuestos;

use Auth;
use Flash;

class ImpuestosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('user');
        parent::__construct($request);
    }

    public function getIndex() {
    	$impuestos = Impuestos::findBy([ 'user' => Auth::user() ]);
    	return $this->render('users.impuestos.index', [ 'impuestos' => $impuestos ]);
    }

    public function getAdd() {
    	return $this->render('users.impuestos.add');
    }

    public function postAdd() {
    	$impuesto = new Impuestos(Auth::user());

    	$impuesto->save($this->request, [], [
    		'validate' => true,
    		'flush' => true,
    	]);

    	Flash::success('Registro agregado correctamente');
    	return redirect()->action('Users\ImpuestosController@getIndex');
    }

    public function getEdit($id) {
    	$impuesto = Impuestos::find($id);

    	if (!$impuesto) {
    		return redirect('/');
    	}

    	return $this->render('users.impuestos.edit', [ 'impuesto' => $impuesto ]);
    }

    public function postEdit($id) {
    	$impuesto = Impuestos::find($id);

    	if (!$impuesto) {
    		return redirect('/');
    	}

    	$impuesto->save($this->request, [], [
    		'validate' => true,
    		'flush' => true,
    	]);

    	Flash::success('Registro editado correctamente');
    	return redirect()->action('Users\ImpuestosController@getIndex');
    }

    public function getDelete($id) {
    	$impuesto = Impuestos::find($id);

    	if (!$impuesto) {
    		return redirect('/');
    	}

    	$impuesto->remove();

    	Flash::success('Registro eliminado correctamente');
    	return redirect()->action('Users\ImpuestosController@getIndex');	
    }

}