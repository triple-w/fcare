<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users;

use Flash;
use Auth;
use Validator;
use Hash;

class PlantillasController extends Controller
{
	public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function getIndex(){
    	$Plantillas = Auth::user();
    	return $this->render('users.plantillas.index', ['Plantillas' => $Plantillas]);
    }

    public function getAdd(){
    	return $this->render('users.plantillas.add');
    }

    public function postAdd(){
    	$user = Auth::user();

    	$user->setPlantillaPDF($this->request->input('plantilla'));
    	$user->flush();

    	if($this->request->ajax()){
    		return $this->JSONResponse();
    	}

    	Flash::success('Plantilla seleccionada correctamente');
    	return redirect()->action('Users\PlantillasController@getIndex');
    } 

    public function getEdit($id){
    	return $this->render('users.plantillas.edit');
    }

    public function postEdit($id){
		
		$user = Auth::user();

    	$user->setPlantillaPDF($this->request->input('plantilla'));
    	$user->flush();    	

    	if($this->request->ajax()){
    		return $this->JSONResponse();
    	}

    	Flash::success('Plantilla seleccionada correctamente');
    	return redirect()->action('Users\PlantillasController@getIndex');
    }

    public function getDelete($id){;
    	$user = Auth::user();

    	$user->setPlantillaPDF(null);
    	$user->flush();

    	Flash::success('Plantilla eliminada correctamente');
    	return redirect()->action('Users\PlantillasController@getIndex');
    }
}