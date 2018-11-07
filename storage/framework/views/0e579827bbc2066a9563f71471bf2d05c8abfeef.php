<!-- resources/views/auth/login.blade.php -->


<?php $__env->startSection('title', 'Cambiar Password'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open();; ?>

        <?php echo BootForm::password('password_actual', 'Password Anterior', ['required' => 'required']);; ?>

        <?php echo BootForm::password('password', 'Password Nuevo', ['required' => 'required']);; ?>

        <?php echo BootForm::password('password_confirmation', 'Password Confirm', ['required' => 'required']);; ?>

        <?php echo BootForm::submit('Agregar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>