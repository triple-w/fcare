<?php

namespace App\Http\Controllers\Pagos;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\UsersPagosTimbres;
use App\Models\TimbresMovs;

use MercadoPago;
use Openpay;
use Auth;
use Flash;

/**
 * Class PagosController
 * @author Me
 */
class TimbresController extends Controller
{

    public function __construct(Request $request) {
        parent::__construct($request);
    }
/*
    public function getPago() {
        return $this->render('pagos.timbres.index');
    }*/

    public function getPago() {
            return $this->render('pagos.timbresmp.index');
    }
/*
    public function postPago() {
        $user = Auth::user();
        $perfil = $user->getPerfil();

        $cantidad = $this->request->input('cantidad');
        $monto = 0;
        $precio = 0;
        switch ($cantidad) {
            case 50:
                $monto = 150;
                $precio = 3;
                break;
            case 100:
                $monto = 220;
                $precio = 2.2;
                break;
            case 200:
                $monto = 380;
                $precio = 1.9;
                break;
            case 500:
                $monto = 750;
                $precio = 1.5;
                break;
            case 1000:
                $monto = 1200;
                $precio = 1.2;
                break;
            case 2000:
                $monto = 2200;
                $precio = 1.1;
                break;
            case 4000:
                $monto = 4000;
                $precio = 1;
                break;
            case 5000:
                $monto = 4720;
                $precio = .95;
                break;
        }

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
            // 'last_name' => $_SESSION['nombre_session'],
            'phone_number' => $perfil->getTelefono(),
            'email' => $user->getEmail(),
        ];

        $chargeData = [
            'method' => 'card',
            'source_id' => $this->request->input('tokenId'),
            'amount' => strval($monto),
            'description' => 'Pago de Timbres',
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

        $admin = Users::findOneBy([ 'username' => 'admin' ]);
        $admin->setTimbresDisponibles($admin->getTimbresDisponibles() - $cantidad);
        $admin->persist();

        $mov = new TimbresMovs($admin);
        $mov->setTipo(TimbresMovs::TRANSFERENCIA);
        $mov->setNumeroTimbres($cantidad);
        $mov->setUserTransferencia($user);

        $user->setTimbresDisponibles($user->getTimbresDisponibles() + $cantidad);
        $user->addTimbresMov($mov);
        $user->persist();

        $pago = new UsersPagosTimbres($user, $mov);
        $pago->setIdTransaccion($charge->id);
        $pago->setAuthorization($charge->authorization);
        $pago->setPrecio($precio);
        $pago->setMonto($monto);
        if ($this->request->has('requieroFactura')) {

            $userFactura = Users::find($this->userFacturaAutomatica);
            $userToFactura = $pago->getUser();
            $preci = number_format($pago->getPrecio(), 2, '.', '');
            $iva = number_format($preci * 0.16, 2, '.', '');
            $data = [
                'Total' => $preci + $iva,
                'SubTotal' => $preci,
                'Descuento' => '0.00',
                'conceptos' => [
                    [
                        'ClaveProdServ' => '84111506',
                        'ClaveUnidad' => 'E48',
                        'NoIdentificacion' => '001',
                        'Cantidad' => '1',
                        'Unidad' => 'Servicio',
                        'Descripcion' => 'Servicio de timbrado en facturacion',
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
            $pago->setRequiereFactura(true);
            $estatusFactura = 'PENDIENTE';
            if ($resFactura) {
                $estatusFactura = 'ENVIADA';
                $pago->setXml($resFactura['xml']);
            }
            $pago->setStatusFactura($estatusFactura);
        }
        $pago->flush();

        $this->sendEmail($this->email, $this->nameEmail, 'Pago de timbres', 'emails.pagos.timbres');
        $mensaje = "Cobro aprobado correctamente";
        Flash::success($mensaje);

        return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
    }
*/
    public function postPago() {

        $user = Auth::user();
        $perfil = $user->getPerfil();

        $cantidad = 0; 

        $monto = $this->request->input('precio');
        $precio = 0;
        /*switch ($cantidad) {
            case 50:
                $monto = 10;
                $precio = 3;
                break;
            case 100:
                $monto = 220;
                $precio = 2.2;
                break;
            case 200:
                $monto = 380;
                $precio = 1.9;
                break;
            case 500:
                $monto = 750;
                $precio = 1.5;
                break;
            case 1000:
                $monto = 1200;
                $precio = 1.2;
                break;
            case 2000:
                $monto = 2200;
                $precio = 1.1;
                break;
            case 4000:
                $monto = 4000;
                $precio = 1;
                break;
            case 5000:
                $monto = 4720;
                $precio = .95;
                break;
        }
*/
        $customer = [
            'first_name' => $perfil->getRfc(),
            // 'last_name' => $_SESSION['nombre_session'],
            /*'phone' => [
                'area_code' => '',
                'number' => $perfil->getTelefono()
            ],*/
            'email' => $user->getEmail(),
        ];

        MercadoPago\SDK::initialize(); 
        $config = MercadoPago\SDK::config(); 

        Mercadopago\SDK::setAccessToken("TEST-98693479437591-071615-c275bb1cea519a2ad027c3847d6d37c7-276903920");
        //... mc 5474925432670366  visa 4075595716483764
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = $monto;
        $payment->token = $this->request->input('token');
        $payment->description = "Timbres";
        $payment->installments = 1;
        //$payment->payment_method_id = "visa";
        $payment->payer = $customer;
        // Save and posting the payment

        //dump($this->request->input('token'));
        //dump($payment);
        $response = $payment->save();
        //dump($response);die;

        if ($response['code'] == 201){
            $status = $payment->status;
            if($status == 'approved'){
                //echo $status;
/*
                $admin = Users::findOneBy([ 'username' => 'admin' ]);
                $admin->setTimbresDisponibles($admin->getTimbresDisponibles() - $cantidad);
                $admin->persist();

                $mov = new TimbresMovs($admin);
                $mov->setTipo(TimbresMovs::TRANSFERENCIA);
                $mov->setNumeroTimbres($cantidad);
                $mov->setUserTransferencia($user);

                $user->setTimbresDisponibles($user->getTimbresDisponibles() + $cantidad);
                $user->addTimbresMov($mov);
                $user->persist();

                $pago = new UsersPagosTimbres($user, $mov);
                $pago->setIdTransaccion($response['body']['id']);
                $pago->setAuthorization($response['body']['id']);
                $pago->setPrecio($precio);
                $pago->setMonto($monto);
                if ($this->request->has('requieroFactura')) {

                    $userFactura = Users::find($this->userFacturaAutomatica);
                    $userToFactura = $pago->getUser();
                    $preci = number_format($pago->getPrecio(), 2, '.', '');
                    $iva = number_format($preci * 0.16, 2, '.', '');
                    $data = [
                        'Total' => $preci + $iva,
                        'SubTotal' => $preci,
                        'Descuento' => '0.00',
                        'conceptos' => [
                            [
                                'ClaveProdServ' => '84111506',
                                'ClaveUnidad' => 'E48',
                                'NoIdentificacion' => '001',
                                'Cantidad' => '1',
                                'Unidad' => 'Servicio',
                                'Descripcion' => 'Servicio de timbrado en facturacion',
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
                    $pago->setRequiereFactura(true);
                    $estatusFactura = 'PENDIENTE';
                    if ($resFactura) {
                        $estatusFactura = 'ENVIADA';
                        $pago->setXml($resFactura['xml']);
                    }
                    $pago->setStatusFactura($estatusFactura);
                }
                $pago->flush();
*/
                $this->sendEmail($this->email, $this->nameEmail, 'Pago de timbres', 'emails.pagos.timbres');
                if($status == 'approved'){
                    $mensaje = "Cobro aprobado correctamente";
                }
                Flash::success($mensaje);
                return redirect()->action('Users\DashboardController@getIndex');

            }
            if($status == 'in_process'){

                $admin = Users::findOneBy([ 'username' => 'admin' ]);
                $admin->setTimbresDisponibles($admin->getTimbresDisponibles() - $cantidad);
                $admin->persist();

                $mov = new TimbresMovs($admin);
                $mov->setTipo(TimbresMovs::TRANSFERENCIA);
                $mov->setNumeroTimbres($cantidad);
                $mov->setUserTransferencia($user);

                $user->addTimbresMov($mov);
                $user->persist();

                $pago = new UsersPagosTimbres($user, $mov);
                $pago->setIdTransaccion($response['body']['id']);
                $pago->setAuthorization($response['body']['id']);
                $pago->setPrecio($precio);
                $pago->setMonto($monto);
                if ($this->request->has('requieroFactura')) {

                    $userFactura = Users::find($this->userFacturaAutomatica);
                    $userToFactura = $pago->getUser();
                    $preci = number_format($pago->getPrecio(), 2, '.', '');
                    $iva = number_format($preci * 0.16, 2, '.', '');
                    $data = [
                        'Total' => $preci + $iva,
                        'SubTotal' => $preci,
                        'Descuento' => '0.00',
                        'conceptos' => [
                            [
                                'ClaveProdServ' => '84111506',
                                'ClaveUnidad' => 'E48',
                                'NoIdentificacion' => '001',
                                'Cantidad' => '1',
                                'Unidad' => 'Servicio',
                                'Descripcion' => 'Servicio de timbrado en facturacion',
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
                    $pago->setRequiereFactura(true);
                    $estatusFactura = 'PENDIENTE';
                    if ($resFactura) {
                        $estatusFactura = 'ENVIADA';
                        $pago->setXml($resFactura['xml']);
                    }
                    $pago->setStatusFactura($estatusFactura);
                }
                $pago->flush();

                $this->sendEmail($this->email, $this->nameEmail, 'Pago de timbres', 'emails.pagos.timbres');

                    $mensaje = "Estamos procesando el pago. En menos de una hora te enviaremos por e-mail el resultado.";
                    Flash::success($mensaje);
                    return redirect()->action('Users\DashboardController@getIndex');   
            }
            if($status == 'rejected'){
                switch ($response['body']['status_detail']) {
                    case 'cc_rejected_insufficient_amount':
                            $mensaje = 'El pago fue rechazado: Fondos insuficientes.';
                        break;

                    case 'cc_rejected_bad_filled_security_code':
                            $mensaje = 'El pago fue rechazado: Revisa el código de seguridad.';
                        break;
                    
                    case 'cc_rejected_call_for_authorize':
                            $mensaje = 'El pago fue rechazado: Llama a tu banco para autorizar el pago a MercadoPago.';
                        break;

                    case 'cc_rejected_bad_filled_date':
                            $mensaje = 'El pago fue rechazado: Revisa la fecha de vencimiento.';
                        break;

                    case 'cc_rejected_bad_filled_other':
                            $mensaje = 'El pago fue rechazado: Revisa los datos.';
                        break;

                    case 'cc_rejected_bad_filled_card_number':
                            $mensaje = 'El pago fue recazado: Revisa el número de tarjeta.';
                        break;

                    case 'cc_rejected_blacklist':
                            $mensaje = 'El pago fue recazado: No pudimos procesar tu pago.';
                        break;

                    case 'cc_rejected_max_attempts':
                            $mensaje = 'El pago fue recazado: Llegaste al límite de intentos permitidos. Elige otra tarjeta u otro medio de pago.';
                        break;

                    case 'cc_rejected_card_disabled':
                            $mensaje = 'El pago fue rechazado: Llama a tu banco para que active tu tarjeta. El teléfono está al dorso de tu tarjeta.';
                        break;

                    case 'cc_rejected_duplicated_payment':
                            $mensaje = 'El pago fue rechazado: Ya hiciste un pago por ese valor. Si necesitas volver a pagar usa otra tarjeta u otro medio de pago.';
                        break;

                    case 'cc_rejected_high_risk':
                            $mensaje = 'El pago fue rechazado: Tu pago fue rechazado. Elige otro de los medios de pago.';
                        break;

                    case 'cc_rejected_other_reason':
                            $mensaje = 'El pago fue rechazado';
                        break;

                    default:
                             $mensaje = 'El pago fue rechazado';
                        break;
                }

                Flash::error($mensaje);
                return redirect()->action('Pagos\TimbresController@getPago');
                //return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }
        }
        else{
            $mensaje = 'error al generar pago: error '.$response['body']['status'].' error '.$response['body']['error'].' mensaje '.$response['body']['message'];
            Flash::error($mensaje);
            return redirect()->action('Pagos\TimbresController@getPago');
            //return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
        }
    }

}
