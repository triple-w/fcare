<?php $__env->startSection('title', 'Editar Impuesto'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php echo BootForm::open(); ?>

        <?php echo BootForm::text('serie', 'Serie', $folio->getSerie(), []); ?>

        <?php echo BootForm::text('folio', 'Folio', $folio->getFolio(), []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>