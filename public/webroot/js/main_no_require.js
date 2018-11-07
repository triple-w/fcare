$(function(){

    $('.eliminar').click(function(event) {
        event.preventDefault();

        var title = $(this).data('title');
        var content = $(this).data('content');

        var modal = $('#modal-elimina-registro');
        if (title !== undefined) {
            modal.find('.modal-title').html(title);
        }
        if (content !== undefined) {
            modal.find('.modal-body').html(content);
        }

        var href = $(this).attr('href');
        modal.find('#href-eliminar').val(href);

        modal.modal('show');

    });

    $('#modal-elimina-registro').find('.aceptar').click(function(event) {
        var href = $('#modal-elimina-registro').find('#href-eliminar').val();
        if (href !== undefined) {
            window.location.href = href;
        }
        event.preventDefault();
    });
    
    $('.envio-facturas').click(function(event) {
        event.preventDefault();
        $('#envio-email').attr('action', $('#envio-email').attr('action') + '/' + $(this).data('id'));
        $('#modal-envio-facturas').modal('show');
    });

    $("[data-toggle=tooltip]").tooltip();

    $('.fixed-to-2').blur(function(event) {
        if ($.isNumeric($(this).val())) {
            $(this).val(parseFloat($(this).val()).toFixed(2));
        } else {
            $(this).val('');
        }
    });

});
