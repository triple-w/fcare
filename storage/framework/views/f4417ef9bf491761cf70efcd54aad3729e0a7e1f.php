
<?php $__env->startSection('title', 'Impuestos'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo HTML::link(action('Users\ImpuestosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Impuesto', [ 'class' => 'btn btn-default' ]); ?>


    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tasa</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($impuestos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $impuesto):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($impuesto->getNombre()); ?></td>
                            <td><?php echo e($impuesto->getTasa()); ?></td>
                            <td><?php echo e($impuesto->getTipo()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\ImpuestosController@getEdit', [ 'id' => $impuesto->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]); ?>

                                <?php echo HTML::link(action('Users\ImpuestosController@getDelete', [ 'id' => $impuesto->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
    <?php echo HTML::scriptLocal('webroot/js/generals.js'); ?>

<?php $__env->appendSection(); ?>
