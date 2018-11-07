
<!-- Core JS files -->
<?php echo HTML::script('assets/vendors/jquery/jquery.min.js'); ?>

<?php echo HTML::script('assets/vendors/tether/dist/js/tether.min.js'); ?>

<?php echo HTML::script('assets/vendors/bootstrap/dist/js/bootstrap.js'); ?>

<?php echo HTML::script('assets/vendors/jquery-mousewheel/jquery.mousewheel.min.js'); ?>

<?php echo HTML::script('assets/vendors/jscrollpane/script/jquery.jscrollpane.min.js'); ?>

<?php echo HTML::script('assets/vendors/spin.js/spin.js'); ?>

<?php echo HTML::script('assets/vendors/ladda/dist/ladda.min.js'); ?>

<?php echo HTML::script('assets/vendors/select2/dist/js/select2.full.min.js'); ?>

<?php echo HTML::script('assets/vendors/html5-form-validation/dist/jquery.validation.min.js'); ?>

<?php echo HTML::script('assets/vendors/jquery-typeahead/dist/jquery.typeahead.min.js'); ?>

<?php echo HTML::script('assets/vendors/jquery-mask-plugin/dist/jquery.mask.min.js'); ?>

<?php echo HTML::script('assets/vendors/autosize/dist/autosize.min.js'); ?>

<?php echo HTML::script('assets/vendors/bootstrap-show-password/bootstrap-show-password.min.js'); ?>

<?php echo HTML::script('assets/vendors/moment/min/moment.min.js'); ?>

<?php echo HTML::script('assets/vendors/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>

<?php echo HTML::script('assets/vendors/fullcalendar/dist/fullcalendar.min.js'); ?>

<?php echo HTML::script('assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js'); ?>

<?php echo HTML::script('assets/vendors/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js'); ?>

<?php echo HTML::script('assets/vendors/summernote/dist/summernote.min.js'); ?>

<?php echo HTML::script('assets/vendors/owl.carousel/dist/owl.carousel.min.js'); ?>

<?php echo HTML::script('assets/vendors/ionrangeslider/js/ion.rangeSlider.min.js'); ?>

<?php echo HTML::script('assets/vendors/nestable/jquery.nestable.js'); ?>

<?php echo HTML::script('assets/vendors/editable-table/mindmup-editabletable.js'); ?>

<?php echo HTML::script('assets/vendors/d3/d3.min.js'); ?>

<?php echo HTML::script('assets/vendors/c3/c3.min.js'); ?>

<?php echo HTML::script('assets/vendors/chartist/dist/chartist.min.js'); ?>

<?php echo HTML::script('assets/vendors/peity/jquery.peity.min.js'); ?>

<?php echo HTML::script('assets/vendors/base/vendors.bundle.js'); ?>

<?php echo HTML::script('assets/demo/demo5/base/scripts.bundle.js'); ?>



<!-- /core JS files -->

<!-- Theme JS files -->

<!--<?php echo HTML::script('assets/js/plugins/pickers/daterangepicker.js'); ?>-->

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

<?php echo HTML::script('assets/vendors/datatables/media/js/jquery.dataTables.min.js'); ?>

<?php echo HTML::script('assets/vendors/datatables/media/js/dataTables.bootstrap4.min.js'); ?>

<?php echo HTML::script('assets/vendors/datatables-fixedcolumns/js/dataTables.fixedColumns.js'); ?>

<?php echo HTML::script('assets/vendors/datatables-responsive/js/dataTables.responsive.js'); ?>