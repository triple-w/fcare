
<?php $__env->startSection('title', 'Cambiar documento'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open([ 'files' => true ]); ?>

        <?php echo BootForm::file('archivo', 'Archivo', [ 'required' => 'required', 'accept' => '.pem' ]); ?>

        <?php echo BootForm::submit('Agregar'); ?>

    <?php echo BootForm::close(); ?>


<?php $__env->stopSection(); ?>