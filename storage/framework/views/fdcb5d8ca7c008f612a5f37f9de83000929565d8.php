
<?php $__env->startSection('title', 'Empleados'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo HTML::link(action('Users\EmpleadosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Empleado', [ 'class' => 'btn btn-default' ]); ?>


    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>RFC</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($empleados);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $empleado):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($empleado->getRfc()); ?></td>
                            <td><?php echo e($empleado->getNombre()); ?></td>
                            <td><?php echo e($empleado->getEmail()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\EmpleadosController@getEdit', [ 'id' => $empleado->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]); ?>

                                <?php echo HTML::link(action('Users\EmpleadosController@getDelete', [ 'id' => $empleado->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
