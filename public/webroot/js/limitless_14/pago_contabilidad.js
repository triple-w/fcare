$(document).ready(function(event) {

    // $('a.terminos-condiciones').click(function(){
    //     window.open(this.href, "terminos y condiciones", "width=600, height=600");
    //     return false;
    // });

    var fns = {
        recalcularTotal: function() {
            var total = 0;
            total += $.isNumeric(parseFloat($('td.contabilidad-total').html())) ? parseFloat($('td.contabilidad-total').html()) : 0.00;
            //total += $.isNumeric(parseFloat($('td.anteriores-total').html())) ? parseFloat($('td.anteriores-total').html()): 0.00;

            $('#contabilidad-resumen-pago').find('tbody > tr > td > h3 > span.total').html(total);
        }
    }

    OpenPay.setId(config.openpay_id);
    OpenPay.setApiKey(config.openpay_pk);
    if (config.env === 'production') {
        OpenPay.setSandboxMode(false);
    } else {
        OpenPay.setSandboxMode(true);
    }
    var deviceSessionId = OpenPay.deviceData.setup();

    $('#contabilidad-payment').submit(function(event) {
        event.preventDefault();
        OpenPay.token.extractFormAndCreate('contabilidad-payment', function(response) {
            var tokenId = response.data.id;
            var mesesAnteriores = "";
            if ($('.meses').length) {
                mesesAnteriores = $('.meses').val();
            }
            var datos = $('#contabilidad-payment').find('.mes-regularizacion, .anio-regularizacion, .nombre-tarjeta, .numero-tarjeta, .cvv-tarjeta, .mes-tarjeta, .anio-tarjeta, .requiero-factura').serialize();
            var url = 'pagos-contabilidad/pago';
            if ($('#estatus').length > 0 && $('#estatus').val() === 'register') {
                url = 'users/register-datos-pago/' + $('#user-id').val();
            }
            fnsGenerales.fnAJAX(url, 'POST', 'tokenId=' + tokenId + "&deviceSession=" + deviceSessionId + "&tipoPlan=" + $('.tipoPlan:checked').val() + "&mesesAnteriores=" + mesesAnteriores + '&' + datos, 'JSON', null, function(response, success) {
                if (success) {
                    var redirect = 'pagos-contabilidad/pago';
                    if ($('#estatus').length > 0 && $('#estatus').val() === 'register') {
                        redirect = 'auth/login/';
                    }
                    window.location.href = config.urlPublic + redirect;
                } else {
                    console.log(response);
                }
            }, function(response) {
                $('.pago').button('loading');
            }, function() {
            });
        });
    });

    $('.elegir-regularizacion').click(function(event) {
        event.preventDefault();
        var meses = $('.meses').val();
        var html = '';
        var ob = $('.seleccion-regularizacion');
        ob.find('.row').removeClass('hide');
        for (i = 1; i < meses; i++) {
            html += ob.html();
        }

        $('.contenido-regularizacion').html(html);

        /*if (config.user.regimen === 621) {
            base = 499.00;
        } else {
            base = 599.00;
        }
        var total = base * meses;
        var iva = total * .16;
        var total = total + iva;*/

        $('#contabilidad-resumen-pago').find('tbody > tr > td.anteriores-meses').html(meses);
       // $('#contabilidad-resumen-pago').find('tbody > tr > td.anteriores-total').html(total.toFixed(2));

        fns.recalcularTotal()
    });

    $('.tipoPlan').click(function(event) {
        var value = $(this).val();
        var meses = 0;
        var total = 0.00;
        switch (value) {
            case '1_MESES':
                meses = 1;
                if (config.user.regimen === 621) {
                    total = 499.00;
                } else {
                    total = 599.00;
                }
                break;
            case '3_MESES':
                meses = 3;
                if (config.user.regimen === 621) {
                    total = 1347.30;
                } else {
                    total = 1617.30;
                }
                break;
            case '6_MESES':
                meses = 6;
                if (config.user.regimen === 621) {
                    total = 2544.90;
                } else {
                    total = 3054.90;
                }
                break;
            case '12_MESES':
                meses = 12;
                if (config.user.regimen === 621) {
                    total = 4790.40;
                } else {
                    total = 5750.40;
                }
                break;
        }

        $('input#mesesAnteriores').val(meses);
        $('.elegir-regularizacion').click();

        var iva = total * .16;
        var total = total + iva;

        $('#contabilidad-resumen-pago').find('tbody > tr > td.contabilidad-meses').html(meses);
        $('#contabilidad-resumen-pago').find('tbody > tr > td.contabilidad-total').html(total.toFixed(2));

        fns.recalcularTotal()
    });


});
