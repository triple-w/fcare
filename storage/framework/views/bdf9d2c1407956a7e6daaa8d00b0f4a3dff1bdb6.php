<?php $__env->startSection('title', 'Reportar Pagos'); ?>

<?php $__env->startSection('content'); ?>

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Revisado</th>
                        <th>Aprobado</th>
                        <th>Cantidad</th>
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
                            <td><?php echo e($pago->getId()); ?></td>
                            <td><?php echo e($pago->getFecha()->format('Y-m-d H:i:s')); ?></td>
                            <td><?php echo e($pago->getUser()->getUsername()); ?></td>
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
                            <td><?php echo e($pago->getCantidad()); ?></td>
                            <td>
                                <?php echo HTML::link(action('ReportarPagos\ReportarPagosController@getView', [ 'id' => $pago->getid() ]), '<i class="icon-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Ver' ]); ?>

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
