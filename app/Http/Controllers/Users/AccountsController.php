<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Users;
//use App\Models\UsersPagosContabilidad;
//use App\Models\UsersPagosContabilidadSubscripciones;
use App\Models\UsersPerfil;
use App\Models\UsersLogo;
use App\Models\UsersInfoFactura;
use App\Models\UsersInfoFacturaDocumentos;
//use App\Models\UsersSolicitudesPeriodos;
//use App\Models\UsersPeriodos;
//use App\Models\UsersPeriodosDocumentos;

use Flash;
use Auth;
use Validator;
use Hash;
//use Zipper;
//use Openpay;

class AccountsController extends Controller
{

    public function __construct(Request $request) {
        $this->middleware('auth', [ 'except' => [
                'getRegister',
                'postRegister',
                'getActivate',
                'getRecovery',
                'postRecovery',
                'getRecoveryEmail',
                'postRecoveryEmail',
                'getRegisterEmailForward',
                'postRegisterEmailForward',
                'getMustChangePassword',
                'postMustChangePassword',
                //'postCambiarPlan',
                //'getRegisterDatosPago',
                //'postRegisterDatosPago',
                //'getRegisterInformacion',
                //'postRegisterInformacion',
            ]
        ]);

        $this->middleware('admin', [ 'only' => [
                'getIndex',
                'getAdd',
                'postAdd',
                'getEdit',
                'postEdit',
                'getVerificate',
                'getForwardEmail',
                'getDocumentosAprobar',
                'getAprobarDocumento',
                'postAprobarDocumento',
                'getNoAprobarDocumento',
                'getDocumentos',
                'getCambiarDocumento',
                'postCambiarDocumento',
                //'getSolicitudesPeriodos',
                //'getSolicitudRevisada',
                //'getUsersNoContabilidad',
                //'getVerificarCiec',
                //'getCiecVerificado',
                //'getBorrarUsuario',
            ]
        ]);

        $this->middleware('user', [ 'only' => [
            'getDatos',
            'postDatos',
            'getBorrarDocumento',
            'getBorrarLogo',
        ]]);

        $this->middleware('app.rules', [ 'only' => [
                'getIndex',
                'getAdd',
                'postAdd',
                'getEdit',
                'postEdit',
                'getVerificate',
                'getForwardEmail',
                'getPerfil',
                'postPerfil',
                'getBorrarLogo',
                'getDatos',
                'postDatos',
                'getBorrarDocumento',
                'getBorrarLogo',
            ]
        ]);

        //FIX better solution to handle validator extends
        Validator::extend('doctrine_unique', function($attribute, $value, $parameters) {
            $user = Users::findOneBy([$parameters[0] => $value]);
            return empty($user);
        });

        Validator::extend('old_password', function($attribute, $value, $parameters) {
            $user = Users::find(Auth::user()->getId());
            return Hash::check($value, $user->getPassword());
        });

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

    public function getPerfil() {
        $user = Auth::user();
        $perfil = $user->getPerfil();

        return $this->render('accounts.perfil', [ 'user' => $user, 'perfil' => $perfil ]);
    }

    public function postPerfil() {
        $user = Auth::user();
        //$provincia = Provincias::find($this->request->input('provincia'));

        $perfil = $user->getPerfil();
        if (empty($perfil)) {
            //$perfil = new UsersPerfil($user, $provincia);
            $perfil = new UsersPerfil($user);
        }

        $numeroRegimen = $this->request->input('numeroRegimen');

        $perfil->setNombreRegimen33(UsersPerfil::getRegimenes33()[$numeroRegimen]);
        $perfil->save($this->request, [], [
            'validate' => true,
        ]);

        $user->setPerfil($perfil);
        if (!empty($_FILES['imagen']['name'])) {
            $fileEntity = new UsersLogo($user);
            $fileEntity->setEntityFile(public_path("uploads/users_logos/"), $_FILES['imagen']);
            $user->setLogo($fileEntity);
        }

        $user->setCompletarPerfil(true);
        /*if (!empty($this->request->input('ciec'))) {
            $perfil->setVerificarCiec(true);
        }*/
        $user->flush();

        if (!empty($this->request->input('thumbnail'))) {
            $thumbnail = $this->request->input('thumbnail');
            $thumbnail = substr(explode(";",$thumbnail)[1], 7);

            file_put_contents("uploads/users_logos/thumbnails/{$user->getLogo()->getName()}", base64_decode($thumbnail));
        }

        Flash::success('Perfil Editado Correctamente');
        return redirect()->action('Users\AccountsController@getPerfil');

    }

    public function getBorrarLogo($id) {
        $file = UsersLogo::find($id);

        if (!$file) {
            return redirect('/');
        }
        $file->remove();

        if (file_exists("uploads/users_logos/thumbnails/{$file->getName()}")) {
            unlink("uploads/users_logos/thumbnails/{$file->getName()}");
        }

        Flash::success('Imagen eliminada correctamente');
        return redirect()->action('Users\AccountsController@getPerfil');
    }

    public function getDatos() {
        $user = Auth::user();

        $infoFactura = $user->getInfoFactura();
        if (empty($infoFactura)) {
            $infoFactura = new UsersInfoFactura($user);
        }

        return $this->render('accounts.datos', compact('user', 'infoFactura'));
    }

    public function postDatos() {
        $user = Auth::user();

        $infoFactura = $user->getInfoFactura();
        if (empty($infoFactura)) {
            $infoFactura = new UsersInfoFactura($user);
        }

        if (!empty($_FILES['archivoCertificado']['name'])) {
            $file = [
                'name' => $_FILES['archivoCertificado']['name'],
                'type' => $_FILES['archivoCertificado']['type'],
                'tmp_name' => $_FILES['archivoCertificado']['tmp_name'],
                'error' => $_FILES['archivoCertificado']['error'],
                'size' => $_FILES['archivoCertificado']['size'],
            ];
            $documento = new UsersInfoFacturaDocumentos($infoFactura);
            $documento->setTipo('ARCHIVO_CERTIFICADO');
            $documento->setEntityFile(public_path('uploads/users_documentos'), $file);
            $infoFactura->addDocumento($documento);

            $this->sendEmail($this->email, $this->nameEmail, 'Documento por aprobar', 'emails.documentos.documentos_por_aprobar');
        }

        if (!empty($_FILES['archivoLlave']['name'])) {
            $file = [
                'name' => $_FILES['archivoLlave']['name'],
                'type' => $_FILES['archivoLlave']['type'],
                'tmp_name' => $_FILES['archivoLlave']['tmp_name'],
                'error' => $_FILES['archivoLlave']['error'],
                'size' => $_FILES['archivoLlave']['size'],
            ];
            $documento = new UsersInfoFacturaDocumentos($infoFactura);
            $documento->setTipo('ARCHIVO_LLAVE');
            $documento->setEntityFile(public_path('uploads/users_documentos'), $file);
            $infoFactura->addDocumento($documento);

            $this->sendEmail($this->email, $this->nameEmail, 'Documento por aprobar', 'emails.documentos.documentos_por_aprobar');
        }

        $infoFactura->save($this->request, [], [
            'validate' => true,
            'flush' => true,
        ]);

        Flash::success('Datos agregados correctamente, en espera de validacion');
        return redirect()->action('Users\AccountsController@getDatos');
    }

    public function getBorrarDocumento($id) {
         $file = UsersInfoFacturaDocumentos::find($id);

        if (!$file) {
            return redirect('/');
        }

        $file->remove();

        if (file_exists(public_path("uploads/users_documentos/{$file->getName()}.pem"))) {
            unlink(public_path("uploads/users_documentos/{$file->getName()}.pem"));
        }

        Flash::success('Documento eliminado correctamente');
        return redirect()->action('Users\AccountsController@getDatos');
    }

    public function getRegister() {
        $this->setLayout('empty');
        return $this->render('auth.register');
    }

    public function postRegister() {
        $user = new Users();

        $admin = $this->request->input('admin');
        $user_admin = \App\Models\Users::findOneBy( ['username' => $admin] );
        if($user_admin == null){
            Flash::error('Error al ingresar su admin');
            return redirect()->action('Users\AccountsController@getRegister');
        }
        $id_admin = $user_admin->getId();
        $user->setVerified(false);
        $user->setActive(true);
        $user->setRecovery(false);
        $user->changeHash();
        $user->changeApiCredential();
        $user->setMustChangePassword(false);
        $user->setRol('ROLE_USUARIO');

        $user->save($this->request, [], [
            'validate' => true,
            'event' => 'add',
            'flush' => true,
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        $user->setAdmin($id_admin);
        $user->flush();

        
        $this->sendEmail($user->getEmail(), $user->getEmail(),
            'Activación de usuario', 'emails.accounts.register', [ 'user' => $user ]);
        //$this->sendEmail($user->getEmail(), $user->getEmail(),
         //   'Registro de usuario', 'emails.accounts.register', [ 'user' => $user ]);

        //return redirect()->action('Users\AccountsController@getRegisterInformacion', [ 'id' => $user->getId() ]);
        Flash::success('Se ha enviado un correo de activacion a la direccion especificada');
        return redirect()->action('Auth\AuthController@getLogin');
    }

/*    public function getRegisterDatosPago($id) {
        $this->setLayout('empty');
        $user = Users::find($id);
        return $this->render('auth.register_datos_pago', compact('user'));
    }

   /* public function postRegisterDatosPago($id) {
        $user = Users::find($id);
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
                'amount' => $precioAtrasado,
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
                $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
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

        // $this->sendEmail($user->getEmail(), $user->getEmail(),
        //     'Activación de usuario', 'emails.accounts.register', [ 'user' => $user ]);
        $this->sendEmail($this->email, $this->nameEmail, 'Se dio de alta un usuario', 'emails.accounts.alta');

        Flash::success('Se ha enviado un correo de activacion a la direccion especificada');

        $mensaje = "Cobro aprobado correctamente";
        return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
    }*/

/*    public function postRegisterDatosPago($id) {
        $user = Users::find($id);
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
                    $mensaje = "Error al aprobar el cobro - {$ex->getMessage()}" ;
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
            $now->addMonths($nuevos_meses + 1);
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
            $pago->setFechaTermino($fechaTermino->addMonths($nuevos_meses + 1));
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

            $this->sendEmail($this->email, $this->nameEmail, 'Se dio de alta un usuario', 'emails.accounts.alta');

            Flash::success('Se ha enviado un correo de activacion a la direccion especificada');

            $mensaje = "Cobro aprobado correctamente";
            return $this->JSONResponse([ 'mensaje' => $mensaje ], true);
            }//endif
    }

    public function getRegisterInformacion($id) {
        $this->setLayout('empty');
        $user = Users::find($id);
        $perfil = $user->getPerfil();
        return $this->render('auth.register_informacion', compact('perfil', 'user'));
    }

    public function postRegisterInformacion($id) {
        $user = Users::find($id);
        //$provincia = Provincias::find($this->request->input('provincia'));

        $perfil = $user->getPerfil();
        if (empty($perfil)) {
            //$perfil = new UsersPerfil($user, $provincia);
            $perfil = new UsersPerfil($user);
        }

        $numeroRegimen = $this->request->input('numeroRegimen');

        $perfil->setNombreRegimen(UsersPerfil::getRegimenes()[$numeroRegimen]);
        $perfil->save($this->request, [], [
            'validate' => true,
        ]);

        $user->setPerfil($perfil);
        if (!empty($_FILES['imagen']['name'])) {
            $fileEntity = new UsersLogo($user);
            $fileEntity->setEntityFile(public_path("uploads/users_logos/"), $_FILES['imagen']);
            $user->setLogo($fileEntity);
        }

        $user->setCompletarPerfil(true);
        if (!empty($this->request->input('ciec'))) {
            $perfil->setVerificarCiec(true);
        }
        $user->flush();

        if (!empty($this->request->input('thumbnail'))) {
            $thumbnail = $this->request->input('thumbnail');
            $thumbnail = substr(explode(";",$thumbnail)[1], 7);

            file_put_contents("uploads/users_logos/thumbnails/{$user->getLogo()->getName()}", base64_decode($thumbnail));
        }

        return redirect()->action('Users\AccountsController@getRegisterDatosPago', [ 'id' => $user->getId() ]);
    }*/

    public function getIndex() {
        if(Auth::user()->getId() == 1){
            $users = Users::findAll();
        }else{
            $users = Users::findBy(['rol' => 'ROLE_USUARIO' , 'admin' => Auth::user()->getId()]);
        }
        return $this->render('accounts.index', [ 'users' => $users ]);
    }

    public function getAdd() {
        $user = new Users();
        return $this->render('accounts.add', [ 'user' => $user ]);
    }

    public function postAdd() {
        $user = new Users();
        $user->setRol('ROLE_ADMIN');
        $user->changeHash();
        $user->setVerified(true);
        $user->setRecovery(false);
        $user->setMustChangePassword(true);
        $user->setApiCredential('TEST');
        $user->setAdmin('1');
        $user->save($this->request, [], [
            'validate' => true,
            'event' => 'add',
            'flush' => true,
        ]);

        Flash::success('Usuario creado correctamente');

        return redirect()->action('Users\AccountsController@getIndex');
    }

    public function getMustChangePassword($id) {
        $this->setLayout('empty');
        return $this->render('accounts.must_change_password');
    }

    public function postMustChangePassword($id) {
        $user = Users::find($id);

        if (!$user) {
            Flash::success('Usuario no encontrado');

            $this->request->session()->flash('noRedirectAuthentified', '');
            return redirect('/');
        }

        $user->setVerified(true);
        $user->setMustChangePassword(false);
        $user->save($this->request, [], [
            'validate' => true,
            'event' => 'must_change_password',
            'flush' => true
        ]);

        Flash::success('Password cambiado correctamente');

        $this->request->session()->flash('noRedirectAuthentified', '');
        return redirect('/');
    }

    public function getActivate($id) {
        $user = Users::find($id);
        if (empty($user)) {
            return redirect('/');
        }


        if (!$user->getVerified()) {

            if ($user->getMustChangePassword()) {
                return redirect()->action('Users\AccountsController@getMustChangePassword', [ 'id' => $id ]);
            }

            $user->setVerified(true);
            $user->save([], [], [
                'validate' => false,
                'flush' => true
            ]);

            Flash::success('Usuario Verificado Correctamente');
        }

        $this->request->session()->flash('noRedirectAuthentified', '');

        return redirect('/');
    }

    public function getRecoveryEmail() {
        $this->setLayout('empty');
        return $this->render('accounts.recovery_password_email');
    }

    public function postRecoveryEmail() {
        $user = Users::findOneBy([ 'username' => $this->request->input('username') ]);
        if ($user) {

            $this->sendEmail($user->getEmail(), $user->getUsername(),
            'Recuperación de password', 'emails.accounts.recovery', [ 'user' => $user ]);
            $user->setRecovery(true);
            $user->save([], [] ,[
                'validate' => false,
                'flush' => true
            ]);

            Flash::success('Se ha enviado un correo de recuperación al correo especificado');
            return redirect('/');
        }

        Flash::info('Usuario no encontrado');
        return redirect()->action('Users\AccountsController@getRecoveryEmail');
    }

    public function getRegisterEmailForward() {
        $this->setLayout('empty');
        return $this->render('accounts.register_email_forward');
    }

    public function postRegisterEmailForward() {
        $user = Users::findOneBy([ 'username' => $this->request->input('username') ]);

        if ($user) {
            if (!$user->getVerified()) {
                $this->sendEmail($user->getEmail(), $user->getEmail(),
                    'Activación de usuario', 'emails.accounts.register', [ 'user' => $user ]);

                Flash::success('Se ha enviado un correo de activacion a la direccion especificada');
                return redirect('/');

            }

            Flash::info('Usuario ya se encuentra activo');
            return redirect()->action('Users\AccountsController@getRegisterEmailForward');
        }

        Flash::info('Usuario no encontrado');
        return redirect()->action('Users\AccountsController@getRegisterEmailForward');
    }

    public function getRecovery($id) {
        $user = Users::find($id);

        if (empty($user) || !$user->getRecovery()) {
            return redirect('/');
        }

        $this->setLayout('empty');
        return $this->render('accounts.recovery_password', [ 'user' => $user ]);
    }

    public function postRecovery($id) {
        $user = Users::find($id);

        if (empty($user) || !$user->getRecovery()) {
            return redirect('/');
        }

        $user->setRecovery(false);
        $user->changeHash();
        $user->save($this->request, [ 'password' ], [
            'validate' => false,
            'flush' => true
        ]);

        Flash::success('Password cambiado correctamente');
        return redirect('/');

    }

    public function getEdit($id) {
        $user = Users::find($id);
        if (!$user) {
            return $this->redirect('/');
        }

        return $this->render('accounts.add', [ 'user' => $user ]);
    }

    public function postEdit($id) {
        $user = Users::find($id);
        if (!$user) {
            return $this->redirect('/');
        }

        //FIX checkbox not render good
        empty($this->request->input('active')) ? $user->setActive(false) : $user->setActive(true);

        $user->save($this->request, [], [
            'validate' => true,
            'event' => 'edit',
            'flush' => true,
        ]);

        Flash::success('Usuario editado correctamente');
        return redirect()->action('Users\AccountsController@getIndex');

    }

    public function getVerificate($id) {
        $user = Users::find($id);
        if (!$user) {
            return $this->redirect('/');
        }
        $user->setVerified(true);
        $user->flush();

        Flash::success('Usuario verificado correctamente');

        return redirect()->action('Users\AccountsController@getIndex');
    }

    public function getForwardEmail($id) {
        $user = Users::find($id);
        if (!$user) {
            return $this->redirect('/');
        }
        $this->sendEmail($user->getEmail(), $user->getUsername(), 'Activación de usuario', 'emails.accounts.register', [ 'user' => $user ]);
        Flash::success('Email enviado correctamente');

        return redirect()->action('Users\AccountsController@getIndex');
    }

    public function getChangePassword() {
        return $this->render('accounts.user_change_password');
    }

    public function postChangePassword() {
        $user = Auth::user();
        if (!$user) {
            return $this->redirect('/');
        }

        $user->save($this->request, [], [
            'validate' => true,
            'event' => 'change_password',
            'flush' => true,
        ]);

        Auth::logout();
        Flash::success('Password Cambiado Correctamente, Porfavor escribe tus nuevas credenciales');
        return redirect('/');
    }

    public function getDocumentosAprobar() {
        $documentos = UsersInfoFacturaDocumentos::findBy([ 'revisado' => false ]);
        return $this->render('users.documentos_aprobar', compact('documentos'));
    }

    public function postNombreAprobar() {
        $documento = UsersInfoFacturaDocumentos::find($this->request->input('ID'));

        $documento->setName($this->request->input('nombre'));

        $documento->flush();

        Flash::success('Nombre Cambiado Correctamente');
        return redirect()->action('Users\AccountsController@getDocumentosAprobar');

    }

    public function getAprobarDocumento($id) {
        return $this->render('users.cambiar_documento');
    }

    public function postAprobarDocumento($id) {
        $documento = UsersInfoFacturaDocumentos::find($id);

        if (!$documento) {
            return redirect('/');
        }

        $archivo = $this->request->file('archivo');
        if (empty($archivo)) {
            Flash::danger('Debes de proveer un archivo');
            return redirect()->action('Users\AccountsController@getDocumentosAprobar');
        }

        $ext = $archivo->getClientOriginalExtension();
        if ($ext !== 'pem') {
            Flash::danger('Debes ser un archivo con extension .pem');
            return redirect()->action('Users\AccountsController@getDocumentosAprobar');
        }

        $path = 'uploads/users_documentos/';
        $nombre = "{$documento->getName()}.pem";
        $archivo->move($path, $nombre);

        $documento->setRevisado(true);
        $documento->setValidado(true);
        $documento->flush();

        Flash::success('Documento cambiado y aprobado correctamente');
        return redirect()->action('Users\AccountsController@getDocumentosAprobar');
    }

    public function getNoAprobarDocumento($id) {
        $documento = UsersInfoFacturaDocumentos::find($id);

        if (!$documento) {
            return redirect('/');
        }

        $documento->setRevisado(true);
        $documento->setValidado(false);
        $documento->flush();

        Flash::success('Documento no aprobado correctamente');
        return redirect()->action('Users\AccountsController@getDocumentosAprobar');
    }

    public function getDocumentos($id) {
        $user = Users::find($id);
        $documentos = $user->getInfoFactura()->getDocumentos();
        return $this->render('users.documentos', compact('documentos'));
    }

    public function getCambiarDocumento($id) {
        return $this->render('users.cambiar_documento');
    }

    public function postCambiarDocumento($id) {
        $documento = UsersInfoFacturaDocumentos::find($id);

        if (!$documento) {
            return redirect('/');
        }

        $archivo = $this->request->file('archivo');
        if (empty($archivo)) {
            Flash::danger('Debes de proveer un archivo');
            return redirect()->action('Users\AccountsController@getDocumentosAprobar');
        }

        $ext = $archivo->getClientOriginalExtension();
        if ($ext !== 'pem') {
            Flash::danger('Debes ser un archivo con extension .pem');
            return redirect()->action('Users\AccountsController@getDocumentosAprobar');
        }

        $path = 'uploads/users_documentos/';
        $nombre = "{$documento->getName()}.pem";
        $archivo->move($path, $nombre);

        Flash::success('Documento cambiado correctamente');
        return redirect()->action('Users\AccountsController@getDocumentos', [ 'id' => $documento->getFacturaInfo()->getUser()->getId() ]);
    }

    public function getQuejasySugerencias() {
        return $this->render('quejas_sugerencias.add');
    }

    public function postQuejasySugerencias() {
        $queja = $this->request->input('sugerencia');
        $user = Auth::user();
        $this->sendEmail($this->email, $this->nameEmail, 'Queja o Sugerencia', 'emails.quejas_sugerencias.add', [ 'queja' => $queja, 'user' => $user ]);

        Flash::success('Sugerencia enviada correctamente');
        return redirect()->action('Users\DashboardController@getIndex');
    }
/*
    public function getPeriodos($id) {
        $user = Users::find($id);

        $periodos = $user->getPeriodos();
        return $this->render('users.periodos.periodos', compact('periodos', 'user'));
    }

    public function getPeriodosTerminados($id) {
        $user = Users::find($id);

        $periodosTerminados = $user->getPeriodosTerminados();
        return $this->render('users.periodos.periodos_terminados', compact('periodosTerminados', 'user'));
    }

    public function getSolicitudesPeriodos($id) {
        $user = Users::find($id);

        $solicitudesPeriodos = UsersSolicitudesPeriodos::findBy([ 'user' => $user, 'revisado' => false ]);
        return $this->render('users.periodos.solicitudes_periodos', compact('solicitudesPeriodos', 'user'));
    }

    public function getSolicitudRevisada($id) {
        $solicitudPeriodo = UsersSolicitudesPeriodos::find($id);

        $solicitudPeriodo->setRevisado(true);
        $solicitudPeriodo->flush();

        Flash::success('Registro actualizado correctamente');
        return redirect()->action('Users\AccountsController@getSolicitudesPeriodos', [ 'id' => $solicitudPeriodo->getUser()->getId() ]);
    }

    public function getUsersNoContabilidad() {
        $users = Users::findAll();
        return $this->render('accounts.no_contabilidad', compact('users'));
    }

    public function getUsersContabilidad() {
        $users = Users::findAll();
        return $this->render('accounts.contabilidad', compact('users'));
    }

    public function postCambiarPlan() {
        $user = Auth::user();
        $ultimaSubscripcion = UsersPagosContabilidadSubscripciones::getUltimaSubscripcion($user);
        $pagoContabilidad = $ultimaSubscripcion->getPagoContabilidad();

        Openpay::setProductionMode(false);
        $openpay = Openpay::getInstance('mkupnbyrogrm2tekg9sd', 'sk_7df2e9fbea044eb9a1b29728e5206158');

        $customerId = $user->getCustomerIdOpenPay();
        $customer = $openpay->customers->get($customerId);
        $subscripcion = $customer->subscriptions->get($ultimaSubscripcion->getIdSubscripcion());
        $subscripcion->delete();

        $precio = 0;
        $tipoPlan = $this->request->input('tipoPlan');
        switch ($tipoPlan) {
            case '1_MESES':
                if ($user->getPerfil()->getNumeroRegimen() === 621) {
                    $precio = 579.00;
                } else {
                    $precio = 695.00;
                }
                break;
            case '3_MESES':
                $precio = 1498.00;
                break;
            case '6_MESES':
                $precio = 2865.00;
                break;
            case '12_MESES':
                $precio = 5490.00;
                break;
        }

        $pagoContabilidad->setTipoPlanNuevo($tipoPlan);
        $pagoContabilidad->setPrecioNuevo($precio);
        $pagoContabilidad->setEstatusNuevo('PENDIENTE');

        $pagoContabilidad->flush();

        Flash::success('Plan cambiado correctamente, el cambio se aplicara al termino del plan actual.');
        return redirect()->action('Users\DashboardController@getIndex');
    }

    public function getVerificarCiec() {
        $perfiles = UsersPerfil::getUsersVerificarCiec();
        return $this->render('accounts.verificar_ciec', compact('perfiles'));
    }

    public function getCiecVerificado($id) {
        $perfil = UsersPerfil::find($id);

        $perfil->setVerificarCiec(false);
        $perfil->setCiecVerificada(true);

        $perfil->flush();

        Flash::success('Ciec Verificada correctamente');
        return redirect()->action('Users\AccountsController@getVerificarCiec');
    }*/

    public function getBorrarUsuario($id){
        $user = Users::find($id);

        try {
            $user->remove();
        } catch(\Exception $e) {
            Flash::error('No se pudo eliminar el usuario. ' . $e->getMessage());
            return redirect()->action('Users\AccountsController@getIndex');
        }

        Flash::success('Usuario eliminado correctamente');
        return redirect()->action('Users\AccountsController@getIndex');        
    }

}

?>
