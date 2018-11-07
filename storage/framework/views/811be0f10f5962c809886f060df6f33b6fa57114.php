
<?php $__env->startSection('title', 'Editar Perfil'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open([ 'id' => 'form-perfil', 'files' => true ]); ?>

        <?php echo BootForm::text('rfc', 'RFC', $perfil->getRfc(), []); ?>

        <?php echo BootForm::text('razonSocial', 'Razon Social', $perfil->getRazonSocial(), []); ?>

        <?php echo BootForm::text('calle', 'Calle', $perfil->getCalle(), []); ?>

        <?php echo BootForm::text('noExt', 'Numero Exterior', $perfil->getNoExt(), []); ?>

        <?php echo BootForm::text('noInt', 'Numero Interior', $perfil->getNoInt(), []); ?>

        <?php echo BootForm::text('colonia', 'Colonia', $perfil->getColonia(), []); ?>

        <?php echo BootForm::text('municipio', 'Municipio', $perfil->getMunicipio(), []); ?>

        <?php echo BootForm::text('localidad', 'Localidad', $perfil->getLocalidad(), []); ?>

        <?php echo BootForm::text('estado', 'Estado', $perfil->getEstado(), []); ?>

        <?php echo BootForm::text('codigoPostal', 'Codigo Postal', $perfil->getCodigoPostal(), []); ?>

        <?php echo BootForm::text('pais', 'Pais', $perfil->getPais(), []); ?>

        <?php echo BootForm::text('telefono', 'Telefono', $perfil->getTelefono(), []); ?>

        <?php echo BootForm::text('nombreContacto', 'Nombre de Contacto', $perfil->getNombreContacto(), []); ?>

        <?php echo BootForm::text('ciec', 'CIEC', $perfil->getCiec(), []); ?>

        <?php echo BootForm::select('numeroRegimen', 'Regimen Fiscal', \App\Models\UsersPerfil::getRegimenes(), $perfil->getNumeroRegimen(), []); ?>

        <div style="max-width: 400px">
        <?php if(!empty($user->getLogo())): ?>
            <?php echo HTML::image("uploads/users_logos/{$user->getLogo()->getName()}", 'Logo', [ 'class' => 'img img-responsive' ]); ?>

            <?php echo HTML::link(action('Users\AccountsController@getBorrarLogo', [ 'id' => $user->getLogo()->getId() ]), 'Eliminar Imagen', [ 'class' => 'btn btn-danger' ]); ?>

        </div><br />
            <br />
        <?php else: ?>
            <div class="row">
                <div class="col-md-6">
                    <img class="show-image" src="" class="img img-responsive">
                </div>
            </div>
            <input type="hidden" name="thumbnail" class="image-thumbnail" value="">
            <?php echo BootForm::file('imagen', 'Logo', [ 'class' => 'imagen-logo' ]); ?>

        <?php endif; ?>
        <?php echo BootForm::submit('Agregar'); ?>

    <?php echo BootForm::close(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/libs/cropper/dist/cropper.js'); ?>

    <?php echo HTML::scriptLocal('webroot/js/limitless_14/perfil.js'); ?>

<?php $__env->appendSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .show-image {
            width:100%
        }
    </style>
    <?php echo HTML::styleLocal('webroot/libs/cropper/dist/cropper.css'); ?>

<?php $__env->appendSection(); ?>
