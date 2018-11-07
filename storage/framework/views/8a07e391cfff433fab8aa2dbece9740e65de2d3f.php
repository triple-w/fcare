
<!-- Core JS files -->
<?php echo HTML::script('assets/vendors/base/vendors.bundle.js'); ?>

<?php echo HTML::script('assets/demo/demo5/base/scripts.bundle.js'); ?>


<!-- /core JS files -->

<!-- Theme JS files -->

<?php echo HTML::script('assets/js/plugins/pickers/daterangepicker.js'); ?>


<!-- /theme JS files -->

<?php echo HTML::scriptLocal('webroot/js/main_no_require.js'); ?>

<?php
    $user = Auth::user();
    $arr = [
        'id' => !empty($user) ? $user->getId() : null,
        'regimen' => !empty($user) && !empty($user->getPerfil()) ? $user->getPerfil()->getNumeroRegimen() : null,
    ];
    $config = [
        'urlPublic' => asset(''),
        'csrfToken' => csrf_token(),
        'user' => $arr,
        'openpay_id' => env('OPENPAY_ID'),
        'openpay_pk' => env('OPENPAY_PK'),
        'openpay_sk' => env('OPENPAY_SK'),
        'env' => env('APP_ENV'),
    ];
?>

<script>
    var config = <?php echo json_encode($config); ?>
</script>