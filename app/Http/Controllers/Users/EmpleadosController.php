<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Empleados;

use Flash;
use Auth;

class EmpleadosController extends Controller
{

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function getInfo($id) {
        $empleado = Empleados::find($id);

        return $this->JSONResponse($empleado->toArray());
    }

    public function getIndex() {
        $empleados = Auth::user()->getEmpleados();
        if ($this->request->ajax()) {
            $empleadosArr = [];
            foreach ($empleados as $empleado) {
                $empleadosArr[] = $empleado->toArray();
            }
            return $this->JSONResponse($empleadosArr);
        }
        return $this->render('users.empleados.index', [ 'empleados' => $empleados ]);
    }

    public function getAdd() {
        return $this->render('users.empleados.add');
    }

    public function postAdd() {
        $empleado = new Empleados(Auth::user());

        $empleado->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        if ($this->request->ajax()) {
            return $this->JSONResponse();
        }

        Flash::success('Registro agregado correctamente');
        return redirect()->action('Users\EmpleadosController@getIndex');
    }

    public function getEdit($id) {
        $empleado = Empleados::find($id);

        if (!$empleado) {
            return redirect('/');
        }

        return $this->render('users.empleados.edit', [ 'empleado' => $empleado ]);
    }

    public function postEdit($id) {
        $empleado = Empleados::find($id);

        if (!$empleado) {
            return redirect('/');
        }

        $empleado->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        Flash::success('Registro editado correctamente');
        return redirect()->action('Users\EmpleadosController@getIndex');
    }

    public function getDelete($id) {
        $empleado = Empleados::find($id);

        if (!$empleado) {
            return redirect('/');
        }

        $empleado->remove();

        Flash::success('Registro eliminado correctamente');
        return redirect()->action('Users\EmpleadosController@getIndex');    
    }

}
