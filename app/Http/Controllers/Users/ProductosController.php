<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Productos;
use App\Models\ClaveProdServ;
use App\Models\ClaveUnidad;

use Auth;
use Flash;

class ProductosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('user');
        parent::__construct($request);
    }

    public function getClaveProdServ() {
        $limit = 100;
        if ($this->request->has('limit')) {
            $limit = $this->request->input('limit');
        }
        $claveProdServ = ClaveProdServ::search($this->request->input('q'), $limit);
        return $this->JSONResponse($claveProdServ);
    }

    public function getClaveUnidad() {
        $limit = 100;
        if ($this->request->has('limit')) {
            $limit = $this->request->input('limit');
        }
        $claveUnidad = ClaveUnidad::search($this->request->input('q'), $limit);
        return $this->JSONResponse($claveUnidad);
    }


    public function getInfo($id) {
        $producto = Productos::find($id);
        return $this->JSONResponse($producto->toArray(null,
            [
                'fields' => [
                    'id',
                    'clave',
                    'observaciones',
                    'descripcion',
                    'unidad',
                    'precio',
                    'claveProdServ',
                    'claveUnidad'
                ],
                'deep' => 0
            ]
        ));
    }

    public function getIndex() {
        $productos = Productos::findBy([ 'user' => Auth::user() ]);
        return $this->render('users.productos.index', [ 'productos' => $productos ]);
    }

    public function getAdd() {
        return $this->render('users.productos.add');
    }

    public function postAdd() {
        $producto = new Productos(Auth::user());

        $producto->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        Flash::success('Producto agregado correctamente');
        return redirect()->action('Users\ProductosController@getIndex');
    }

    public function getEdit($id) {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/');
        }

        return $this->render('users.productos.edit', [ 'producto' => $producto ]);
    }

    public function postEdit($id) {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/');
        }

        $producto->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        Flash::success('Producto editado correctamente');
        return redirect()->action('Users\ProductosController@getIndex');
    }

    public function getDelete($id) {
        $producto = Productos::find($id);

        if (!$producto) {
            return redirect('/');
        }

        $producto->remove();

        Flash::success('Producto eliminado correctamente');
        return redirect()->action('Users\ProductosController@getIndex');
    }

}