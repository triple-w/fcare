<?php $__env->startSection('title', 'Reportar Pagos'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo HTML::link(action('Users\ReportarPagosController@getAdd'), '<i class="icon-plus2" aria-hidden="true"></i> Nuevo Reporte de Pago', [ 'class' => 'btn btn-default' ]); ?>


    <br />
    <br />

    <h3>
        <p class="text-center">Información de Cuentas de Pago</p>
    </h3>
    <p class="text-center">Nombre: GRUPO OM ASEN, S.C.</p>
    <p class="text-center">Cuenta: 0101511696</p>
    <p class="text-center">Clabe: 012320001015116960</p>
    <p class="text-center">Banco: BANCOMER</p>

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Revisado</th>
                        <th>Aprobado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($pagos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $pago):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($pago->getFecha()->format('Y-m-d H:i:s')); ?></td>
                            <td><?php echo e($pago->getCantidad()); ?></td>
                            <td>
                                <?php if($pago->getRevisado()): ?>
                                    <?php echo Label::success('Revisado'); ?>

                                <?php else: ?>
                                    <?php echo Label::danger('No Revisado'); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($pago->getAprobado()): ?>
                                    <?php echo Label::success('Aprobado'); ?>

                                <?php else: ?>
                                    <?php echo Label::danger('No Aprobado'); ?>

                                <?php endif; ?>
                            </td>
                            <td><?php echo e($pago->getObservaciones()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\ReportarPagosController@getView', [ 'id' => $pago->getid() ]), '<i class="icon-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Ver' ]); ?>

                                <?php if(($pago->getRevisado() && !$pago->getAProbado()) || !$pago->getRevisado()): ?>
                                    <?php echo HTML::link(action('Users\ReportarPagosController@getEdit', [ 'id' => $pago->getid() ]), '<i class="icon-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]); ?>

                                <?php endif; ?>
                                <?php if(!$pago->getRevisado()): ?>
                                    <?php echo HTML::link(action('Users\ReportarPagosController@getDelete', [ 'id' => $pago->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/limitless_14/generals.js'); ?>

<?php $__env->appendSection(); ?>
