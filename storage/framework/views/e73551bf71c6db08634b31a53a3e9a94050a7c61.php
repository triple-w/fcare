
<?php $__env->startSection('title', 'Propuestas'); ?>

<?php $__env->startSection('content'); ?>

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($propuestas);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $propuesta):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($propuesta->getMes()); ?> - <?php echo e($propuesta->getAnio()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\PeriodosMovimientosPropuestasController@getView', [ 'id' => $propuesta->getid() ]), '<i class="icon-eye" aria-hidden="true"></i>', [ 'class' => 'btn btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Ver' ]); ?>

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
