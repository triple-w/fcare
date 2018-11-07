<?php $__env->startSection('title', 'Agregar Cliente'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open(); ?>

        <?php echo BootForm::text('rfc', 'RFC', null, []); ?>

        <?php echo BootForm::text('razonSocial', 'Razon Social', null, []); ?>

        <?php echo BootForm::text('calle', 'Calle', null, []); ?>

        <?php echo BootForm::text('noExt', 'Numero Exterior', null, []); ?>

        <?php echo BootForm::text('noInt', 'Numero Interior', null, []); ?>

        <?php echo BootForm::text('colonia', 'Colonia', null, []); ?>

        <?php echo BootForm::text('municipio', 'Municipio', null, []); ?>

        <?php echo BootForm::text('localidad', 'Localidad', null, []); ?>

        <?php echo BootForm::text('estado', 'Estado', null, []); ?>

        <?php echo BootForm::text('codigoPostal', 'Codigo Postal', null, []); ?>

        <?php echo BootForm::text('pais', 'Pais', null, []); ?>

        <?php echo BootForm::text('telefono', 'Telefono', null, []); ?>

        <?php echo BootForm::text('nombreContacto', 'Nombre de Contacto', null, []); ?>

        <?php echo BootForm::text('email', 'Email', null, []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>
