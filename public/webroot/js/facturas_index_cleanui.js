$(function(){

    $('.envio-facturas').click(function(event) {
        event.preventDefault();
        $('#envio-email').attr('action', $('#envio-email').attr('action') + '/' + $(this).data('id'));
        $('#modal-envio-facturas').modal('show');
    });

});
