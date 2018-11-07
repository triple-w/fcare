<?php $__env->startSection('title', 'Quejas y Sugerencias'); ?>

<?php $__env->startSection('content'); ?>

    <h3>Ayudanos a mejorar</h3>
    <?php echo BootForm::open(); ?>

        <?php echo BootForm::textarea('queja', '¿Qué te gustaría eliminar o complementar a la plataforma?', null, []); ?>

        <?php echo BootForm::submit('Enviar'); ?>

    <?php echo BootForm::close(); ?>


<?php $__env->stopSection(); ?>
