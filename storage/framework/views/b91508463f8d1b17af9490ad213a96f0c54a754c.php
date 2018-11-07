<?php $__env->startSection('title', 'Timbres'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('elements.form_pago', [ 'attrsForm' => [ 'id' => 'timbres-payment'], 'tipo' => 'TIMBRES' ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <?php echo HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0'); ?>

    <?php echo HTML::scriptLocal('webroot/js/limitless_14/pago_timbres.js?v=1.4.0'); ?>

<?php $__env->appendSection(); ?>
