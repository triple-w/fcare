<?php $__env->startSection('title', 'Agregar Impuesto'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open(); ?>

        <?php echo BootForm::select('tipo', 'Tipo', \App\Models\Folios::getDiffFolios(Auth::user(), \App\Models\Folios::getTiposFolio()), null, []); ?>

        <?php echo BootForm::text('serie', 'Serie', null, []); ?>

        <?php echo BootForm::text('folio', 'Folio', null, []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>
