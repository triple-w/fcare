
<?php $__env->startSection('title', 'Productos'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo HTML::link(action('Users\ProductosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Producto', [ 'class' => 'btn btn-default' ]); ?>


    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($productos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $producto):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($producto->getClave()); ?></td>
                            <td><?php echo e($producto->getDescripcion()); ?></td>
                            <td><?php echo e($producto->getPrecio()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\ProductosController@getEdit', [ 'id' => $producto->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]); ?>

                                <?php echo HTML::link(action('Users\ProductosController@getDelete', [ 'id' => $producto->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
