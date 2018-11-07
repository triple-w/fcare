
<?php $__env->startSection('title', 'Clientes'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo HTML::link(action('Users\ClientesController@getAdd'), '<i class="icon-plus2" aria-hidden="true"></i> Nuevo Cliente', [ 'class' => 'btn btn-default' ]); ?>


    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>RFC</th>
                        <th>Razon social</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($clientes);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $cliente):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($cliente->getRfc()); ?></td>
                            <td><?php echo e($cliente->getRazonSocial()); ?></td>
                            <td><?php echo e($cliente->getEmail()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\ClientesController@getEdit', [ 'id' => $cliente->getid() ]), '<i class="icon-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]); ?>

                                <?php echo HTML::link(action('Users\ClientesController@getDelete', [ 'id' => $cliente->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
