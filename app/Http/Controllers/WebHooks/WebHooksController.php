<?php

namespace App\Http\Controllers\WebHooks;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UsersPagosContabilidad;
use App\Models\UsersPagosContabilidadSubscripciones;

class WebHooksController extends Controller
{

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function postOpenPay() {
    $data = $this->request->all();
    if (isset($data['transaction']['subscription_id']) && $data['type'] === 'charge.succeeded') {
        $subscription = UsersPagosContabilidadSubscripciones::findOneBy([ 'idSubscripcion' => $data['transaction']['subscription_id'] ]);
        $pagoContabilidad = $subscription->getPagoContabilidad();
        $user = $pagoContabilidad->getUser();
        $ultimoPago = UsersPagosContabilidad::getUltimoPago($user);
        $tipoPlan = $pagoContabilidad->getTipoPlan();
        $precio = 0;
        $descargas = 0;
        switch ($tipoPlan) {
            case '1_MESES':
                $precio = 549.00;
                $descargas = 1;
            break;
            case '3_MESES':
                $precio = 1498.00;
                $descargas = 3;
            break;
            case '6_MESES':
                $precio = 2865.00;
                $descargas = 6;
            break;
            case '12_MESES':
                $precio = 5490.00;
                $descargas = 12;
            break;
        }
        $totalDescargas = UsersPagosContabilidad::getUltimoPago($user);
        $totalDescargas = $descargas;
        if (!empty($ultimoPago)) {
            $totalDescargas = $descargas + $ultimoPago->getDescargasDisponibles();
        }

        $pago = new UsersPagosContabilidad($user);
        $pago->setIdTransaccion($data['transaction']['id']);
        $pago->setAuthorization($data['transaction']['authorization']);
        $pago->setTipoPlan($tipoPlan);
        $pago->setPrecio($precio);
        $pago->setDescargasDisponibles($totalDescargas);
        $pago->setDescargasCompradas($descargas);
        $pago->flush();
    }

       // \Log::debug($this->request->all());
    }

}
