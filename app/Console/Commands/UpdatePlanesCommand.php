<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdatePlanesCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'app:update_planes';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Update Plan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pagosContabilidad = \App\Models\UsersPagosContabilidad::getUpdatePlanes();
        foreach ($pagosContabilidad as $pagoContabilidad) {
            $user = $pagoContabilidad->getUser();
            $ultimaSubscripcion = \App\Models\UsersPagosContabilidadSubscripciones::getUltimaSubscripcion($user);
            $pagoContabilidad = $ultimaSubscripcion->getPagoContabilidad();

            $id = env('OPENPAY_ID');
            $sk = env('OPENPAY_SK');
            $env = env('APP_ENV');

            $openpay = \Openpay::getInstance($id, $sk);
            if ($env === 'production') {
                \Openpay::setProductionMode(true);
            } else {
                \Openpay::setProductionMode(false);
            }

            $precio = 0;
            $tipoPlan = $pagoContabilidad->getTipoPlanNuevo();
            $descargas = 0;
            $meses = 0;
            switch ($tipoPlan) {
                case '1_MESES':
                    if ($user->getPerfil()->getNumeroRegimen() === 621) {
                        $precio = 810.00;
                    } else {
                        $precio = 549.00;
                    }
                    $descargas = 1;
                    $meses = 1;
                    break;
                case '3_MESES':
                    $precio = 1498.00;
                    $descargas = 3;
                    $meses = 3;
                    break;
                case '6_MESES':
                    $precio = 2865.00;
                    $descargas = 6;
                    $meses = 6;
                    break;
                case '12_MESES':
                    $precio = 5490.00;
                    $descargas = 12;
                    $meses = 12;
                    break;
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
                $plan = $openpay->plans->add($planData);
            }

            $customerId = $user->getCustomerIdOpenPay();
            $customer = $openpay->customers->get($customerId);

            $now = \Carbon\Carbon::now();
            $now->subDay();

            $subscriptionData = [
                'trial_end_date' => $now->format('Y-m-d'),
                'plan_id' => $plan->id,
                'card_id' => $ultimaSubscripcion->getIdCard()
            ];
            $subscripcionNueva = $customer->subscriptions->add($subscriptionData);

            $totalDescargas = $descargas;
            if (!empty($ultimoPago)) {
                $totalDescargas = $descargas + $ultimoPago->getDescargasDisponibles();
            }
            $pago = new \App\Models\UsersPagosContabilidad($user);
            $pago->setIdTransaccion($subscripcionNueva->transaction->id);
            $pago->setAuthorization($subscripcionNueva->transaction->authorization);
            $pago->setTipoPlan($tipoPlan);
            $pago->setPrecio($precio);
            $pago->setTipo('RECURRENTE');
            $pago->setDescargasDisponibles($totalDescargas);
            $pago->setDescargasCompradas($descargas);
            $pago->setRequiereFactura($pagoContabilidad->getRequiereFactura());
            $pago->setStatusFactura($pagoContabilidad->getStatusFactura());
            $pago->persist();

            $pagoContabilidad->setEstatusNuevo('CAMBIADO');
            $pagoContabilidad->persist();

            $pagoSubscripcion = new \App\Models\UsersPagosContabilidadSubscripciones($pago);
            $pagoSubscripcion->setIdSubscripcion($subscripcionNueva->id);
            $pagoSubscripcion->setIdPlan($subscripcionNueva->plan_id);
            $pagoSubscripcion->setIdCustomer($subscripcionNueva->customer_id);
            $pagoSubscripcion->setIdCard($ultimaSubscripcion->getIdCard());
            $pagoSubscripcion->flush();

            $this->info('Subscripcion actualizada Correctamente');
        }
    }
}
