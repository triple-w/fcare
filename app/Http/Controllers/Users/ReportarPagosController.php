<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ReportarPagos;
use App\Models\ReportarPagosImagenes;

use Auth;
use Flash;
use Validator;

class ReportarPagosController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('user');

        Validator::extend('types', function($attribute, $value, $parameters)
        {
            if (is_array($value)) {
                foreach ($value as $file) {
                    if (!empty($file) && !array_key_exists($file->getClientOriginalExtension(), array_flip($parameters))) {
                        return false;
                    }
                }
            } else {
                if (!empty($value) && !array_key_exists($value->getClientOriginalExtension(), array_flip($parameters))) {
                    return false;
                }
            }

            return true;
        });

        parent::__construct($request);
    }

    public function getIndex() {
        $pagos = ReportarPagos::findBy([ 'user' => Auth::user() ]);
        return $this->render('users.reportar_pagos.index', [ 'pagos' => $pagos ]);
    }

    public function getView($id) {
        $pago = ReportarPagos::find($id);

        if (!$pago) {
            return redirect('/');
        }

        return $this->render('users.reportar_pagos.view', compact('pago'));
    }

    public function getAdd() {
        return $this->render('users.reportar_pagos.add');
    }

    public function postAdd() {
        $user = Auth::user();
        $pago = new ReportarPagos($user);

        for($i=0; $i<count($_FILES['images']['name']); $i++) {
            $file = array(
                "name" => $_FILES['images']['name'][$i],
                "type" => $_FILES['images']['type'][$i],
                "tmp_name" => $_FILES['images']['tmp_name'][$i],
                "error" => $_FILES['images']['error'][$i],
                "size" => $_FILES['images']['size'][$i]
            );

            if (!empty($file['name'])) {
                $image = new ReportarPagosImagenes($pago);
                $image->setEntityFile(public_path("uploads/users_reportar_pagos"), $file);
                $pago->addImagene($image);
            }
        }

        $pago->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        $this->sendEmail($this->email, $this->nameEmail, 'Reporte de Pago', 'emails.reportar_pagos.pago_por_aprobar');

        Flash::success('Reporte de pago agregado correctamente');
        return redirect()->action('Users\ReportarPagosController@getIndex');
    }

    public function getEdit($id) {
        $pago = ReportarPagos::find($id);

        if (!$pago) {
            return redirect('/');
        }

        return $this->render('users.reportar_pagos.edit', [ 'pago' => $pago ]);
    }

    public function postEdit($id) {
        $pago = ReportarPagos::find($id);

        if (!$pago) {
            return redirect('/');
        }

        for($i=0; $i<count($_FILES['images']['name']); $i++) {
            $file = array(
                "name" => $_FILES['images']['name'][$i],
                "type" => $_FILES['images']['type'][$i],
                "tmp_name" => $_FILES['images']['tmp_name'][$i],
                "error" => $_FILES['images']['error'][$i],
                "size" => $_FILES['images']['size'][$i]
            );

            if (!empty($file['name'])) {
                $image = new ReportarPagosImagenes($pago);
                $image->setEntityFile(public_path("uploads/users_reportar_pagos"), $file);
                $pago->addImagene($image);
            }
        }

        $v = true;
        if (!$pago->getRevisado()) {
            $v = false;
        }

        $pago->setRevisado(false);
        $pago->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        $msj = '';
        if ($v) {
            $this->sendEmail($this->email, $this->nameEmail, 'Reporte de Pago', 'emails.reportar_pagos.pago_por_aprobar');
            $msj = ', Se envia a revisión';
        }

        Flash::success('Reporte de pago editado correctamente' . $msj);
        return redirect()->action('Users\ReportarPagosController@getIndex');
    }

    public function getDeleteImagen($id) {
        $imagen = ReportarPagosImagenes::find($id);

        if (!$imagen) {
            return redirect('/');
        }

        $imagen->remove();

        Flash::success('Imagen eliminada correctamente');
        return redirect()->action('Users\ReportarPagosController@getEdit', [ 'id' => $imagen->getReportarPago()->getId() ]);
    }

    public function getDelete($id) {
        $pago = ReportarPagos::find($id);

        if (!$pago) {
            return redirect('/');
        }

        $pago->remove();

        Flash::success('Reporte de pago eliminado correctamente');
        return redirect()->action('Users\ReportarPagosController@getIndex');
    }

}
