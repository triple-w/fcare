
<?php $__env->startSection('title', 'Agregar Timbres'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open();; ?>

        <?php echo BootForm::text('numeroTimbres', 'Numero de timbres', null, []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>