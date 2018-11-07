<?php $__env->startSection('title', 'Editar Producto'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open(); ?>

    <?php echo BootForm::select('claveProdServ', 'Clave de Servicio', [], [], [ 'id' => 'clave-prod-serv', 'data-id' => $producto->getClaveProdServ()->getId(), 'data-text' => $producto->getClaveProdServ()->getDescripcion(), 'data-url' => 'productos/clave-prod-serv' ]); ?>

    <?php echo BootForm::select('claveUnidad', 'Clave de Unidad', [], [], [ 'id' => 'clave-unidad', 'data-id' => $producto->getClaveUnidad()->getid(), 'data-text' => $producto->getClaveUnidad()->getDescripcion(), 'data-url' => 'productos/clave-unidad' ]); ?>

        <?php echo BootForm::text('clave', 'Clave', $producto->getClave(), []); ?>

        <?php echo BootForm::text('unidad', 'Unidad', $producto->getUnidad(), []); ?>

        <?php echo BootForm::text('precio', 'Precio', $producto->getPrecio(), []); ?>

        <?php echo BootForm::text('descripcion', 'Descripcion', $producto->getDescripcion(), []); ?>

        <?php echo BootForm::textarea('observaciones', 'Observaciones', $producto->getObservaciones(), []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::script('assets/js/plugins/forms/selects/select2.min.js'); ?>

    <?php echo HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0'); ?>

    <?php echo HTML::scriptLocal('webroot/js/limitless_14/productos_add.js'); ?>

<?php $__env->appendSection(); ?>