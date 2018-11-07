$(document).ready(function(event) {

    // $('a.terminos-condiciones').click(function(){
    //     window.open(this.href, "terminos y condiciones", "width=600, height=600");
    //     return false;
    // });

    OpenPay.setId(config.openpay_id);
    OpenPay.setApiKey(config.openpay_pk);
    if (config.env === 'production') {
        OpenPay.setSandboxMode(false);
    } else {
        OpenPay.setSandboxMode(true);
    }
    var deviceSessionId = OpenPay.deviceData.setup();
    console.log(config);

    $('#timbres-payment').submit(function(event) {
        event.preventDefault();
        OpenPay.token.extractFormAndCreate('timbres-payment', function(response) {
            var tokenId = response.data.id;
            var datos = $('#timbres-payment').find('.requiero-factura').serialize();
            fnsGenerales.fnAJAX('pagos-timbres/pago', 'POST', 'tokenId=' + tokenId + "&deviceSession=" + deviceSessionId + "&cantidad=" + $('.cantidad:checked').val() + "&" + datos, 'JSON', null, function(response, success) {
                if (success) {
                    window.location.href = config.urlPublic + 'pagos-timbres/pago';
                } else {
                    console.log(response);
                }
            }, function(response) {
                $('.pago').button('loading');
            });
        });
    });

    $('.cantidad').click(function(event) {
        var value = $(this).val();
        var monto = 0.00;
        switch (value) {
            case "50":
                monto = 150;
                break;
            case "100":
                monto = 220;
                break;
            case "200":
                monto = 380;
                break;
            case "500":
                monto = 750;
                break;
            case "1000":
                monto = 1200;
                break;
            case "2000":
                monto = 2200;
                break;
            case "4000":
                monto = 4000;
                break;
            case "5000":
                monto = 4720;
                break;
        }

        var iva = monto * .16;
        var monto = monto + iva;

        $('#timbres-resumen-pago').find('tbody > tr > td.timbres-paquete').html(value);
        $('#timbres-resumen-pago').find('tbody > tr > td.timbres-total').html('$' + monto.toFixed(2));

        $('.total').html(monto.toFixed(2));
    });
});
