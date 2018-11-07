
<?php $__env->startSection('title', 'Aprobar Documentos'); ?>

<?php $__env->startSection('content'); ?>

    <table class="table" datatable>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Contraseña</th>
                <th>Tipo documento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
app('blade.helpers')->get('loop')->newLoop($documentos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $documento):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                <tr>
                    <?php echo BootForm::open([ 'action' => 'Users\AccountsController@postNombreAprobar' ]);; ?>

                    <td><?php echo e($documento->getFacturaInfo()->getUser()->getUsername()); ?></td>
                    <td>
                        <?php echo BootForm::text('nombre', false, $documento->getName(),[]); ?>

                        <?php echo BootForm::text('ID', false, $documento->getId(),['hidden']); ?>

                    </td>
                    <td><?php echo e($documento->getTipo() === \App\Models\UsersInfoFacturaDocumentos::LLAVE ? $documento->getFacturaInfo()->getPassword() : ''); ?></td>
                    <td><?php echo e($documento->getTipo()); ?></td>
                    <td>
                        <?php echo BootForm::submit('Guardar Nombre');; ?>

                        <?php echo HTML::link(asset("/uploads/users_documentos/{$documento->getName()}"), 'Descargar', [ 'class' => 'btn btn-info' ]); ?>

                        <?php echo HTML::link(action('Users\AccountsController@getAprobarDocumento', [ 'id' => $documento->getId() ]), 'Aprobar y Cambiar', [ 'class' => 'btn btn-success' ]); ?>

                        <?php echo HTML::link(action('Users\AccountsController@getNoAprobarDocumento', [ 'id' => $documento->getId() ]), 'No Aprobar', [ 'class' => 'btn btn-danger' ]); ?>

                    </td>
                    <?php echo BootForm::close();; ?>

                </tr>
            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
        </tbody>
    </table>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/limitless_14/generals.js'); ?>

<?php $__env->appendSection(); ?>