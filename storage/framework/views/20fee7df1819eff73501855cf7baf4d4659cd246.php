<?php $__env->startSection('title', 'Contabilidad'); ?>

<?php $__env->startSection('content'); ?>

    <?php $ultimaSubscripcion = \App\Models\UsersPagosContabilidadSubscripciones::getUltimaSubscripcion(Auth::user()); $__data['ultimaSubscripcion'] = \App\Models\UsersPagosContabilidadSubscripciones::getUltimaSubscripcion(Auth::user()); ?>
    <?php if(empty($ultimaSubscripcion)): ?>
        <div class="alert alert-warning">
            No se ha encontrado ninguna suscripción activa.
        </div>
        <?php echo $__env->make('elements.form_pago', [ 'attrsForm' => [ 'id' => 'contabilidad-payment'], 'tipo' => 'CONTABILIDAD', 'estatus' => 'app' ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>
        <?php $pago = $ultimaSubscripcion->getPagoContabilidad(); $__data['pago'] = $ultimaSubscripcion->getPagoContabilidad(); ?>
        <?php $now = \Carbon\Carbon::now(); $__data['now'] = \Carbon\Carbon::now(); ?>
        <?php $fechaPago = $pago->getFechaPago(); $__data['fechaPago'] = $pago->getFechaPago(); ?>
        <?php $diff = $now->diffInMonths($pago->getFechaPago()); $__data['diff'] = $now->diffInMonths($pago->getFechaPago()); ?>
        <?php $vencido = false; $__data['vencido'] = false; ?>
        <?php if($pago->getTipoPlan() === '1_MESES' && $diff >= 1): ?>
            <?php $vencido = true; $__data['vencido'] = true; ?>
        <?php elseif($pago->getTipoPlan() === '3_MESES' && $diff >= 3): ?>
            <?php $vencido = true; $__data['vencido'] = true; ?>
        <?php elseif($pago->getTipoPlan() === '6_MESES' && $diff >= 6): ?>
            <?php $vencido = true; $__data['vencido'] = true; ?>
        <?php elseif($pago->getTipoPlan() === '12_MESES' && $diff >= 12): ?>
            <?php $vencido = true; $__data['vencido'] = true; ?>
        <?php endif; ?>
        <?php if($vencido): ?>
            <?php echo $__env->make('elements.form_pago', [ 'attrsForm' => [ 'id' => 'contabilidad-payment'], 'tipo' => 'CONTABILIDAD', 'estatus' => 'app' ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
            <div class="alert alert-info">
                Tienes vigente un plan.
            </div>
            <p>Tipo de plan: <?php echo e($pago->getTipoPlan()); ?></p>
            <p>Fecha de vencimiento: <?php echo e($pago->getFechaTermino()); ?>

            </p>
            <?php
                $id = env('OPENPAY_ID');
                $sk = env('OPENPAY_SK');
                $env = env('APP_ENV');

                $openpay = Openpay::getInstance($id, $sk);
                if ($env === 'production') {
                    Openpay::setProductionMode(true);
                } else {
                    Openpay::setProductionMode(false);
                }

                $customerId = Auth::user()->getCustomerIdOpenPay();
                $customer = $openpay->customers->get($customerId);
                $subscripcion = $customer->subscriptions->get($ultimaSubscripcion->getIdSubscripcion());
            ?>
            <p>Tarjeta: <?php echo e($subscripcion->card->serializableData['card_number']); ?></p>

            <?php $planPendiente = \App\Models\UsersPagosContabilidad::getPlanPendiente(Auth::user()); $__data['planPendiente'] = \App\Models\UsersPagosContabilidad::getPlanPendiente(Auth::user()); ?>
            <?php if(empty($planPendiente)): ?>
                <h3>Mi plan actual: <?php echo e($ultimaSubscripcion->getPagoContabilidad()->getTipoPlan()); ?></h3>
                <p>Deseas cambiar de plan?</p>
                <?php echo BootForm::open([ 'url' => action('Users\AccountsController@postCambiarPlan') ]); ?>

                    <?php echo BootForm::radios('tipoPlan', 'Tipo de Plan', \App\Models\UsersPagosContabilidad::getTiposPlanes() , null, null, [ 'class' => 'tipoPlan', 'required' => true ]); ?>

                    <?php echo BootForm::submit('Cambiar'); ?>

                <?php echo BootForm::close(); ?>

            <?php else: ?>
                <h3>Tienes un cambio de plan pendiente:</h3>
                <p>Plan Nuevo: <?php echo e($planPendiente->getTipoPlanNuevo()); ?></p>
            <?php endif; ?>

        <?php endif; ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <?php echo HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0'); ?>

    <?php echo HTML::scriptLocal('webroot/js/limitless_14/pago_contabilidad.js?v=1.7.0'); ?>

<?php $__env->appendSection(); ?>
