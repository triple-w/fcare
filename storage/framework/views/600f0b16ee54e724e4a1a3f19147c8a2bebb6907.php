<?php $__env->startSection('title', 'Ver Reporte de pago'); ?>

<?php $__env->startSection('content'); ?>

    <h3>Usuario</h3>
    <p><?php echo e($pago->getUser()->getUsername()); ?></p>

    <h3>Cantidad</h3>
    <p><?php echo e($pago->getCantidad()); ?></p>

    <h3>Fecha</h3>
    <p><?php echo e($pago->getFecha()->format('Y-m-d H:i:s')); ?></p>

    <h3>Observaciones</h3>
    <p><?php echo e($pago->getObservaciones()); ?></p>

    <?php
app('blade.helpers')->get('loop')->newLoop($pago->getImagenes());
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $image):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
        <?php echo HTML::link(asset("uploads/users_reportar_pagos/{$image->getName()}"), HTML::image("uploads/users_reportar_pagos/{$image->getName()}", '', [ 'class' => 'imag',  'width' => '150', 'height' => '150' ]), [ 'target' => '_blank' ]); ?>

    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>

    <?php if(!$pago->getRevisado()): ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo HTML::link(action('ReportarPagos\ReportarPagosController@getAprobarPago', [ 'id' => $pago->getid() ]), '<i class="icmn-file-check2" aria-hidden="true"></i>', [ 'class' => 'btn btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Aprobar' ]); ?>

                <?php echo HTML::link(action('ReportarPagos\ReportarPagosController@getNoAprobarPago', [ 'id' => $pago->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'No Aprobar' ]); ?>

            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
