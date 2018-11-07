<?php

namespace App\Http\Controllers\Pagos;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\UsersPagosContabilidad;
use App\Models\UsersPagosContabilidadSubscripciones;
use App\Models\UsersSolicitudesPeriodos;

use Openpay;
use Auth;
use Flash;
use MultiPac;

/**
 * Class PagosController
 * @author Me
 */
class ContabilidadController extends Controller
{

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function getPago() {
        //echo  "OpenPayID: ".env('OPENPAY_ID') ." - OpenPaySK: ". env('OPENPAY_SK') . " - Entorno: ". env('APP_ENV');
        return $this->render('pagos.contabilidad.index');
    }

   /* public function postPago() {
        $user = Auth::user();
        $perfil = $user->getPerfil();

        $precio = 0;
        $tipoPlan = $this->request->input('tipoPlan');
        $descargas = 0;
        $meses = 0;
        switch ($tipoPlan) {
            case '1_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 499.00;
                } else {
                    $precio = 599.00;
                }
                $descargas = 1;
                $meses = 1;
                break;
            case '3_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 1347.30;
                } else {
                    $precio = 1617.30;
                }
                $descargas = 3;
                $meses = 3;
                break;
            case '6_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 2544.90;
                } else {
                    $precio = 3054.90;
                }
                $descargas = 6;
                $meses = 6;
                break;
            case '12_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 4790.40;
                } else {
                    $precio = 5750.40;
                }
                $descargas = 12;
                $meses = 12;
                break;
        }
        $iva = $precio + .16;
        $precio += $iva;

        $id = env('OPENPAY_ID');
        $sk = env('OPENPAY_SK');
        $env = env('APP_ENV');

        $openpay = Openpay::getInstance($id, $sk);
        if ($env === 'production') {
            Openpay::setProductionMode(true);
        } else {
            Openpay::setProductionMode(false);
        }

        $mesesAnteriores = $this->request->input('mesesAnteriores');
        $pagoAtrasado = null;
        if (!empty($mesesAnteriores)) {
            $numeroMeses = count($this->request->input('mesRegularizacion'));

            if ($user->getPerfil()->getNumeroRegimen() === 621) {
                $precioAtrasadoBase = 499.00;
            } else {
                $precioAtrasadoBase = 599.00;
            }
            $precioAtrasado = $precioAtrasadoBase * $numeroMeses;
            $iva = $precioAtrasado + .16;
            $precioAtrasado += $iva;
            $descargasAtrasado = $numeroMeses;

            $customer = [
                'name' => $perfil->getRfc(),
                // 'last_name' => $_SESSION['nombre_session'],
                'phone_number' => $perfil->getTelefono(),
                'email' => $user->getEmail(),
            ];

            $chargeData = [
                'method' => 'card',
                'source_id' => $this->request->input('tokenId'),
                'amount' => strval($precioAtrasado),
                'description' => 'Pago de contabilidad (Meses Anteriores)',
                'device_session_id' => $this->request->input('deviceSession'),
                'customer' => $customer,
            ];

            try {
                $charge = $openpay->charges->create($chargeData);
            } catch (\Exception $ex) {
                $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
                Flash::error($mensaje);
                return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }

            $resFactura = false;
            if ($this->request->has('requieroFactura')) {

                $userFactura = Users::find($this->userFacturaAutomatica);
                $userToFactura = $user;
                $iva = number_format($precioAtrasado * .16, 2, '.', '');
                $preci = number_format($precioAtrasado, 2, '.', '');
                $data = [
                    'Total' => $preci + $iva,
                    'SubTotal' => $preci,
                    'Descuento' => '0.00',
                    'conceptos' => [
                        [
                            'ClaveProdServ' => '84111500',
                            'ClaveUnidad' => 'E48',
                            'NoIdentificacion' => '001',
                            'Cantidad' => '1',
                            'Unidad' => 'Servicio',
                            'Descripcion' => 'Servicio de Contabilidad Electronica',
                            'ValorUnitario' => $preci,
                            'Importe' => $preci,
                            'Descuento' => '0.00',
                            'ImpuestosTrasladados' => [
                                [
                                    'Base' => $preci,
                                    'Impuesto' => '002',
                                    'TasaOCuota' => '0.1600',
                                    'Importe' => $iva,
                                ]
                            ]
                        ]
                    ],
                    'trasladosSuma' => [
                        [
                            'Impuesto' => '002',
                            'TipoFactor' => 'Tasa',
                            'TasaOCuota' => '0.1600',
                            'Importe' => $iva,
                        ]
                    ],
                    'TotalImpuestosTrasladados' => $iva,
                    'TotalImpuestosRetenidos' => '0.00',
                    'email' => $userToFactura->getEmail(),
                ];
                $resFactura = MultiPac::generarFacturaWhitData($userFactura, $userToFactura, $data);
            }

            $ultimoPago = UsersPagosContabilidad::getUltimoPago($user);
            $totalDescargasAtrasado = $descargasAtrasado;
            if (!empty($ultimoPago)) {
                $totalDescargasAtrasado = $descargasAtrasado + $ultimoPago->getDescargasDisponibles();
            }

            $pagoAtrasado = new UsersPagosContabilidad($user);
            $pagoAtrasado->setIdTransaccion($charge->id);
            $pagoAtrasado->setAuthorization($charge->authorization);
            $pagoAtrasado->setPrecio($precioAtrasado);
            $pagoAtrasado->setTipo('ATRASADO');
            $fechaTermino = \Carbon\Carbon::now();
            $pagoAtrasado->setDescargasDisponibles($totalDescargasAtrasado);
            $pagoAtrasado->setDescargasCompradas($descargasAtrasado);
            if ($this->request->has('requieroFactura')) {
                $pagoAtrasado->setRequiereFactura(true);
                $estatusFactura = 'PENDIENTE';
                if ($resFactura) {
                    $estatusFactura = 'ENVIADA';
                    $pagoAtrasado->setXml($resFactura['xml']);
                }
                $pagoAtrasado->setStatusFactura($estatusFactura);
            }
            $pagoAtrasado->persist();

            $solicitud = new UsersSolicitudesPeriodos($user);
            $solicitud->setMeses($this->request->input('mesesAnteriores'));
            $solicitud->setMesesSolicitud($this->request->input('mesRegularizacion'));
            $solicitud->setAniosSolicitud($this->request->input('anioRegularizacion'));
            $solicitud->persist();
        }

        $plans = $openpay->plans->getList([]);
        $plan = null;
        foreach ($plans as $planList) {
            if (
                $planList->repeat_every === $meses
                && $planList->amount === $precio
            ) {
                $plan = $planList;
            }
        }
        if (empty($plan)) {
            $planData = [
                'amount' => strval($precio),
                'status_after_retry' => 'cancelled',
                'retry_times' => 2,
                'name' => 'Suscripcion Easytaxes Contabilidad ' . $meses . ' meses',
                'repeat_unit' => 'month',
                'trial_days' => '0',
                'repeat_every' => $meses,
                'currency' => 'MXN',
            ];
            try {
                $plan = $openpay->plans->add($planData);
            } catch (\Exception $ex) {
                $mensaje = "Error al aprobar el cobro p - {$ex->getMessage()}" ;
                Flash::error($mensaje);
                return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }
        }

        $customer = null;
        if (!empty($user->getCustomerIdOpenPay())) {
            $customer = $openpay->customers->get($user->getCustomerIdOpenPay());
        } else {
            $customerData = [
                'name' => $user->getUsername(),
                'email' => $user->getEmail(),
            ];
            try {
                $customer = $openpay->customers->add($customerData);
            } catch (\Exception $ex) {
                $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
                Flash::error($mensaje);
                return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }
            $user->setCustomerIdOpenPay($customer->id);
            $user->persist();
        }
        if (!$user->getLlenarDatosPago()) {
            $user->setLlenarDatosPago(true);
            $user->persist();
        }

        $card = null;
        $cards = $customer->cards->getList([]);
        foreach ($cards as $cardList) {
            if (
                substr($cardList->serializableData['card_number'], -4) === substr($this->request->input('numeroTarjeta'), -4)
                && $cardList->serializableData['expiration_year'] == $this->request->input('anioExpiracion')
                && $cardList->serializableData['expiration_month'] == $this->request->input('mesExpiracion')
            ) {
                $card = $cardList;
            }
        }

        if (empty($card)) {
            $cardData = [
                'holder_name' => $this->request->input('nombreTitular'),
                'card_number' => $this->request->input('numeroTarjeta'),
                'cvv2' => $this->request->input('cvv'),
                'expiration_month' => $this->request->input('mesExpiracion'),
                'expiration_year' => $this->request->input('anioExpiracion'),
            ];
            $customer = $openpay->customers->get($customer->id);
            try {
                $card = $customer->cards->add($cardData);
            } catch (\Exception $ex) {
                $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
                Flash::error($mensaje);
                return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }
        }

        $now = \Carbon\Carbon::now();
        $now->addMonths(1);
        $subscriptionData = [
            'trial_end_date' => $now->format('Y-m-d'),
            'plan_id' => $plan->id,
            'card_id' => $card->id
        ];

        $customer = $openpay->customers->get($customer->id);
        try{
            $subscription = $customer->subscriptions->add($subscriptionData);
        } catch (\Exception $ex) {
            $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
            Flash::error($mensaje);
            return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
        }

        $ultimoPago = UsersPagosContabilidad::getUltimoPago($user);
        $totalDescargas = $descargas;
        if (empty($pagoAtrasado)) {
            if (!empty($ultimoPago)) {
                $totalDescargas = $descargas + $ultimoPago->getDescargasDisponibles();
            } else {
                $totalDescargas = $totalDescargas + 1;
            }
        } else {
            $totalDescargas = $descargas + $pagoAtrasado->getDescargasDisponibles();
        }

        $pago = new UsersPagosContabilidad($user);
        $pago->setTipoPlan($tipoPlan);
        $pago->setPrecio($precio);
        $pago->setTipo('PLAN');
        $fechaTermino = \Carbon\Carbon::now();
        $pago->setFechaTermino($fechaTermino->addMonths($meses + 1));
        $pago->setDescargasDisponibles($totalDescargas + 1);
        $pago->setDescargasCompradas($descargas);
        if ($this->request->has('requieroFactura')) {
            $pago->setRequiereFactura(true);
            $pago->setStatusFactura('PENDIENTE');
        }
        $pago->persist();

        $pagoSubscripcion = new UsersPagosContabilidadSubscripciones($pago);
        $pagoSubscripcion->setIdSubscripcion($subscription->id);
        $pagoSubscripcion->setIdPlan($subscription->plan_id);
        $pagoSubscripcion->setIdCustomer($subscription->customer_id);
        $pagoSubscripcion->setIdCard($card->id);
        $pagoSubscripcion->flush();

        $this->sendEmail($this->email, $this->nameEmail, 'Pago de contabilidad', 'emails.pagos.contabilidad');
        $mensaje = "Cobro aprobado correctamente";

        Flash::success($mensaje);

        return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
    }*/


    public function postPago() {
        $user = Auth::user();
        $perfil = $user->getPerfil();

        $precio = 0;
        $tipoPlan = $this->request->input('tipoPlan');
        $descargas = 0;
        $meses = 0;
        switch ($tipoPlan) {
            case '1_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 499.00;
                } else {
                    $precio = 599.00;
                }
                $descargas = 1;
                $meses = 1;
                break;
            case '3_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 1347.30;
                } else {
                    $precio = 1617.30;
                }
                $descargas = 3;
                $meses = 3;
                break;
            case '6_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 2544.90;
                } else {
                    $precio = 3054.90;
                }
                $descargas = 6;
                $meses = 6;
                break;
            case '12_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 4790.40;
                } else {
                    $precio = 5750.40;
                }
                $descargas = 12;
                $meses = 12;
                break;
        }
        $iva = $precio * .16;
        $precio += $iva;
        $precio = number_format($precio, 2, '.', '');

        $id = env('OPENPAY_ID');
        $sk = env('OPENPAY_SK');
        $env = env('APP_ENV');

        $openpay = Openpay::getInstance($id, $sk);
        if ($env === 'production') {
            Openpay::setProductionMode(true);
        } else {
            Openpay::setProductionMode(false);
        }


        $customer = [
            'name' => $perfil->getRfc(),
            'phone_number' => $perfil->getTelefono(),
            'email' => $user->getEmail(),
        ];

        $chargeData = [
            'method' => 'card',
            'source_id' => $this->request->input('tokenId'),
            'amount' => $precio,
            'description' => 'Suscripcion '.$meses.' meses (Primer pago)',
            'device_session_id' => $this->request->input('deviceSession'),
            'customer' => $customer,
        ];

        try {
            $charge = $openpay->charges->create($chargeData);
            $error = false;
        } catch (\Exception $ex) {
            $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
            Flash::error($mensaje);
            $error = true;
            return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
        }

        if (!$error){
            $resFactura = false;
            if ($this->request->has('requieroFactura')) {

                $userFactura = Users::find($this->userFacturaAutomatica);
                $userToFactura = $user;
                $iva = number_format($iva, 2, '.', '');
                $preci = number_format($precio, 2, '.', '');
                $data = [
                    'Total' => $preci + $iva,
                    'SubTotal' => $preci,
                    'Descuento' => '0.00',
                    'conceptos' => [
                        [
                            'ClaveProdServ' => '84111500',
                            'ClaveUnidad' => 'E48',
                            'NoIdentificacion' => '001',
                            'Cantidad' => '1',
                            'Unidad' => 'Servicio',
                            'Descripcion' => 'Servicio de Contabilidad Electronica',
                            'ValorUnitario' => $preci,
                            'Importe' => $preci,
                            'Descuento' => '0.00',
                            'ImpuestosTrasladados' => [
                                [
                                    'Base' => $preci,
                                    'Impuesto' => '002',
                                    'TasaOCuota' => '0.1600',
                                    'Importe' => $iva,
                                ]
                            ]
                        ]
                    ],
                    'trasladosSuma' => [
                        [
                            'Impuesto' => '002',
                            'TipoFactor' => 'Tasa',
                            'TasaOCuota' => '0.1600',
                            'Importe' => $iva,
                        ]
                    ],
                    'TotalImpuestosTrasladados' => $iva,
                    'TotalImpuestosRetenidos' => '0.00',
                    'email' => $userToFactura->getEmail(),
                ];
                $resFactura = MultiPac::generarFacturaWhitData($userFactura, $userToFactura, $data);
            }

        $mesesAnteriores = $this->request->input('mesesAnteriores');
        $pagoAtrasado = null;
        $nuevos_meses = $meses;
        if (!empty($mesesAnteriores)) {
            $numeroMeses = count($this->request->input('mesRegularizacion'));
            $descargasAtrasado = $numeroMeses;
            
            $nuevos_meses = $meses - $numeroMeses; //descontar meses atrasados

            $ultimoPago = UsersPagosContabilidad::getUltimoPago($user);
            $totalDescargasAtrasado = $descargasAtrasado;
            if (!empty($ultimoPago)) {
                $totalDescargasAtrasado = $descargasAtrasado + $ultimoPago->getDescargasDisponibles();
            }

            $pagoAtrasado = new UsersPagosContabilidad($user);
            $pagoAtrasado->setIdTransaccion($charge->id);
            $pagoAtrasado->setAuthorization($charge->authorization);
            $pagoAtrasado->setPrecio($precio);
            $pagoAtrasado->setTipo('ATRASADO');
            $fechaTermino = \Carbon\Carbon::now();
            $pagoAtrasado->setDescargasDisponibles($totalDescargasAtrasado);
            $pagoAtrasado->setDescargasCompradas($descargasAtrasado);
            if ($this->request->has('requieroFactura')) {
                $pagoAtrasado->setRequiereFactura(true);
                $estatusFactura = 'PENDIENTE';
                if ($resFactura) {
                    $estatusFactura = 'ENVIADA';
                    $pagoAtrasado->setXml($resFactura['xml']);
                }
                $pagoAtrasado->setStatusFactura($estatusFactura);
            }
            $pagoAtrasado->persist();

            $solicitud = new UsersSolicitudesPeriodos($user);
            $solicitud->setMeses($this->request->input('mesesAnteriores'));
            $solicitud->setMesesSolicitud($this->request->input('mesRegularizacion'));
            $solicitud->setAniosSolicitud($this->request->input('anioRegularizacion'));
            $solicitud->persist();
        }

        $plans = $openpay->plans->getList([]);
        $plan = null;
        foreach ($plans as $planList) {
            if (
                $planList->repeat_every === $meses
                && $planList->amount === $precio
            ) {
                $plan = $planList;
            }
        }
        if (empty($plan)) {
            $planData = [
                'amount' => $precio,
                'status_after_retry' => 'cancelled',
                'retry_times' => 2,
                'name' => 'Suscripcion Easytaxes Contabilidad ' . $meses . ' meses',
                'repeat_unit' => 'month',
                'trial_days' => '0',
                'repeat_every' => $meses,
                'currency' => 'MXN',
            ];
            try {
                $plan = $openpay->plans->add($planData);
            } catch (\Exception $ex) {
                $mensaje = "Error al aprobar el cobro p - {$ex->getMessage()}" ;
                Flash::error($mensaje);
                return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }
        }

        $customer = null;
        if (!empty($user->getCustomerIdOpenPay())) {
            $customer = $openpay->customers->get($user->getCustomerIdOpenPay());
        } else {
            $customerData = [
                'name' => $user->getUsername(),
                'email' => $user->getEmail(),
            ];
            try {
                $customer = $openpay->customers->add($customerData);
            } catch (\Exception $ex) {
                $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
                Flash::error($mensaje);
                return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }
            $user->setCustomerIdOpenPay($customer->id);
            $user->persist();
        }
        if (!$user->getLlenarDatosPago()) {
            $user->setLlenarDatosPago(true);
            $user->persist();
        }

        $card = null;
        $cards = $customer->cards->getList([]);
        foreach ($cards as $cardList) {
            if (
                substr($cardList->serializableData['card_number'], -4) === substr($this->request->input('numeroTarjeta'), -4)
                && $cardList->serializableData['expiration_year'] == $this->request->input('anioExpiracion')
                && $cardList->serializableData['expiration_month'] == $this->request->input('mesExpiracion')
            ) {
                $card = $cardList;
            }
        }

        if (empty($card)) {
            $cardData = [
                'holder_name' => $this->request->input('nombreTitular'),
                'card_number' => $this->request->input('numeroTarjeta'),
                'cvv2' => $this->request->input('cvv'),
                'expiration_month' => $this->request->input('mesExpiracion'),
                'expiration_year' => $this->request->input('anioExpiracion'),
            ];
            $customer = $openpay->customers->get($customer->id);
            try {
                $card = $customer->cards->add($cardData);
            } catch (\Exception $ex) {
                $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
                Flash::error($mensaje);
                return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }
        }

        $ultimasub = UsersPagosContabilidadSubscripciones::getUltimaSubscripcion($user);
        if (empty($ultimasub)) {//si no hay subsccripciones
            $nuevos_meses += 1; //se agrega el mes gratis
        }

        $now = \Carbon\Carbon::now();
        $now->addMonths($nuevos_meses);

        $subscriptionData = [
            'trial_end_date' => $now->format('Y-m-d'),
            'plan_id' => $plan->id,
            'card_id' => $card->id
        ];

        $customer = $openpay->customers->get($customer->id);
        try{
            $subscription = $customer->subscriptions->add($subscriptionData);
        } catch (\Exception $ex) {
            $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
            Flash::error($mensaje);
            return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
        }

        $ultimoPago = UsersPagosContabilidad::getUltimoPago($user);
        $totalDescargas = $descargas;
        if (empty($pagoAtrasado)) {
            if (!empty($ultimoPago)) {
                $totalDescargas = $descargas + $ultimoPago->getDescargasDisponibles();
            } else {
                $totalDescargas += 1;
            }
        } else {
            $totalDescargas = $descargas + $pagoAtrasado->getDescargasDisponibles();
        }

        $pago = new UsersPagosContabilidad($user);
        $pago->setTipoPlan($tipoPlan);
        $pago->setPrecio($precio);
        $pago->setTipo('PLAN');
        $fechaTermino = \Carbon\Carbon::now();
        $pago->setFechaTermino($fechaTermino->addMonths($nuevos_meses));
        $pago->setDescargasDisponibles($totalDescargas);
        $pago->setDescargasCompradas($descargas);
        if ($this->request->has('requieroFactura')) {
            $pago->setRequiereFactura(true);
            $pago->setStatusFactura('PENDIENTE');
        }
        $pago->persist();

        $pagoSubscripcion = new UsersPagosContabilidadSubscripciones($pago);
        $pagoSubscripcion->setIdSubscripcion($subscription->id);
        $pagoSubscripcion->setIdPlan($subscription->plan_id);
        $pagoSubscripcion->setIdCustomer($subscription->customer_id);
        $pagoSubscripcion->setIdCard($card->id);
        $pagoSubscripcion->flush();

        $this->sendEmail($this->email, $this->nameEmail, 'Pago de contabilidad', 'emails.pagos.contabilidad');
        $mensaje = "Cobro aprobado correctamente";

        Flash::success($mensaje);

        return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
        } //endiferror
    }

}
