<?php $__env->startSection('title', 'Agregar Impuesto'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php echo BootForm::open(); ?>

        <?php echo BootForm::text('nombre', 'Nombre', null, []); ?>

        <?php echo BootForm::text('tasa', 'Tasa %', null, [ 'class' => 'fixed-to-2' ]); ?>

        <?php echo BootForm::select('tipo', 'Tipo', [ 'TRASLADO' => 'Traslado', 'RETENCION' => 'Retención' ], [], []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>