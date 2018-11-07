
<!-- Core JS files -->
{!! HTML::script('assets/js/plugins/loaders/pace.min.js') !!}
{!! HTML::script('assets/js/core/libraries/jquery.min.js') !!}
{!! HTML::script('assets/js/core/libraries/bootstrap.min.js') !!}
{!! HTML::script('assets/js/plugins/loaders/blockui.min.js') !!}
<!-- /core JS files -->

<!-- Theme JS files -->
{!! HTML::script('assets/js/plugins/ui/moment/moment.min.js') !!}
{!! HTML::script('assets/js/plugins/tables/datatables/datatables.min.js') !!}
{!! HTML::script('assets/js/plugins/pickers/daterangepicker.js') !!}
{!! HTML::script('assets/js/plugins/pickers/anytime.min.js') !!}
{!! HTML::script('assets/js/plugins/pickers/pickadate/picker.js') !!}
{!! HTML::script('assets/js/plugins/pickers/pickadate/picker.date.js') !!}
{!! HTML::script('assets/js/plugins/pickers/pickadate/picker.time.js') !!}
{!! HTML::script('assets/js/plugins/pickers/pickadate/legacy.js') !!}

{!! HTML::script('assets/js/core/app.js') !!}

{!! HTML::script('assets/js/plugins/ui/ripple.min.js') !!}
<!-- /theme JS files -->

{!! HTML::scriptLocal('webroot/js/main_no_require.js') !!}
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

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5a3831bbf4461b0b4ef89764/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<!-- <script> -->
<!--     window.intergramId = "301620493"; -->
<!--     window.intergramCustomizations = { -->
<!--         titleClosed: 'En que podemos ayudarte?', -->
<!--         titleOpen: 'Comentanos tu duda', -->
<!--         introMessage: 'Comentanos tu duda', -->
<!--         autoResponse: 'Espera, en un momento te atenderemos', -->
<!--         autoNoResponse: 'Por el momento no estamos disponibles, pero en cuanto lo estemos te ayudaremos con todo gusto.', -->
<!--     }; -->
<!-- </script> -->
<!-- <script id="intergram" type="text/javascript" src="https://www.intergram.xyz/js/widget.js"></script> -->
