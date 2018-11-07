
<?php $__env->startSection('title', 'Documentos de usuario'); ?>

<?php $__env->startSection('content'); ?>

    <table class="table" datatable>
        <thead>
            <tr>
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
                    <td><?php echo e($documento->getTipo() === \App\Models\UsersInfoFacturaDocumentos::LLAVE ? $documento->getFacturaInfo()->getPassword() : ''); ?></td>
                    <td><?php echo e($documento->getTipo()); ?></td>
                    <td>
                        <?php echo HTML::link(asset("/uploads/users_documentos/{$documento->getName()}"), 'Descargar', [ 'class' => 'btn btn-info' ]); ?>

                        <?php echo HTML::link(action('Users\AccountsController@getCambiarDocumento', [ 'id' => $documento->getId() ]), 'Cambiar', [ 'class' => 'btn btn-success' ]); ?>

                    </td>
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
    <?php echo HTML::scriptLocal('webroot/js/generals.js'); ?>

<?php $__env->appendSection(); ?>
