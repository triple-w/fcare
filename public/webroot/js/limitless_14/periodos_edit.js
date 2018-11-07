$(function(){

    $('.documento-pagado').submit(function(event) {
        $('.mensaje').addClass('hide');
        event.preventDefault();
        fnsGenerales.fnAJAX('periodos/documento-pagado', 'POST', $(this).serialize(), 'JSON', null, function(response, success) {
            if (success) {
                // var pagado = parseFloat(trob.find('td:eq(5)').html().substr(1).replace(',', ''));
                // var montoPagado = parseFloat($('.monto-pagar').val());
                // var total = pagado + montoPagado;
                if (response.data === 'correcto') {
                    trob.find('td:eq(6)').html('$' + response.pagado);
                    $('#modal-datos-pagado').modal('hide');
                } else {
                    $('.mensaje').removeClass('hide');
                }
            } else {
                $('.mensaje').removeClass('hide');
            }
        });
    });

    var trob;
    $('.fecha-pagado').click(function(event) {
        trob = $(this).closest('tr');
        var pagado = parseFloat($(this).closest('tr').find('td:eq(6)').html().substr(1).replace(',', ''));
        var total = parseFloat($(this).closest('tr').find('td:eq(7)').html().substr(1).replace(',', ''));
        var restante = total - pagado;

        $('.documento-id').val($(this).data('id'));
        $('.monto-pagar').val(restante.toFixed(2));
    });
})
