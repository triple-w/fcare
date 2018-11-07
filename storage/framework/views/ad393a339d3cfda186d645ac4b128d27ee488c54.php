<?php $__env->startSection('title', 'Agregar Cliente'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php echo BootForm::open(); ?>

        <?php echo BootForm::text('rfc', 'RFC', $cliente->getRfc(), []); ?>

        <?php echo BootForm::text('razonSocial', 'Razon Social', $cliente->getRazonSocial(), []); ?>

        <?php echo BootForm::text('calle', 'Calle', $cliente->getCalle(), []); ?>

        <?php echo BootForm::text('noExt', 'Numero Exterior', $cliente->getNoExt(), []); ?>

        <?php echo BootForm::text('noInt', 'Numero Interior', $cliente->getNoInt(), []); ?>

        <?php echo BootForm::text('colonia', 'Colonia', $cliente->getColonia(), []); ?>

        <?php echo BootForm::text('municipio', 'Municipio', $cliente->getMunicipio(), []); ?>

        <?php echo BootForm::text('localidad', 'Localidad', $cliente->getLocalidad(), []); ?>

        <?php echo BootForm::text('estado', 'Estado', $cliente->getEstado(), []); ?>

        <?php echo BootForm::text('codigoPostal', 'Codigo Postal', $cliente->getCodigoPostal(), []); ?>

        <?php echo BootForm::text('pais', 'Pais', $cliente->getPais(), []); ?>

        <?php echo BootForm::text('telefono', 'Telefono', $cliente->getTelefono(), []); ?>

        <?php echo BootForm::text('nombreContacto', 'Nombre de Contacto', $cliente->getNombreContacto(), []); ?>

        <?php echo BootForm::text('email', 'Email', $cliente->getEmail(), []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>