
<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('content'); ?>
<!--
    <?php echo HTML::link(action('Users\AccountsController@getAdd'), 'Agregar', [ 'class' => 'btn btn-default', 'icon' => 'plus-circle' ]); ?>

-->
    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable >
                <thead>
                    <tr>
                        <th>Nombre contacto</th>
                        <th>RFC</th>
                        <th>Email</th>
                        <th>Razón social</th>
                        <th>Teléfono</th>
                        <th>Último Login</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($users);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $user):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <?php $perfil = $user->getPerfil() ?>
                        <tr>
                            <td><?php echo e($perfil->getNombreContacto()); ?></td>
                            <td><?php echo e($user->getUsername()); ?></td>
                            <td><?php echo e($user->getEmail()); ?></td>
                            <td><?php echo e($perfil->getRazonSocial()); ?></td>
                            <td><?php echo e($perfil->getTelefono()); ?></td>
                            <td><?php echo e($user->getLastLogin()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\AccountsController@getEdit', [ 'id' => $user->getId() ]), 'Ver más', ['class' => 'btn btn-default' ]); ?>

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