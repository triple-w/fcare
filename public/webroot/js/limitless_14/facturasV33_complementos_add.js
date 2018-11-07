$(function(){

    $('select').select2();

    $('#clientes').change(function(event) {
        $('div.mensaje-cliente').html('');
        if ($('#clientes').val() !== null) {
            var id = $('#clientes').val();
            fnsGenerales.fnAJAX('clientes/info/' + id, 'GET', {}, 'JSON', null, function(response, success) {
                if (success && response.success) {
                    $.each(response.data, function(key, value) {
                        $('.cliente-' + key).val(value);
                    });
                }
            });
        }
    }).trigger('change');

    //progress bar
    $("#progressbar").progressbar();

    $('#form-wizard').wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function( event, state ) {
            switch (state.stepIndex) {
                case 2:
                break;
                case 3:
                break;
                case 4:
                    $('.clone-productos').html('');

                    var table = $('.table-productos').clone();
                    table.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                    table.find('tbody > tr > td > input').remove();
                    $('.clone-productos').html(table);

                    $('.clone-facturas').html('');
                    var table = $('.table-facturas').clone();
                    table.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                    table.find('tbody > tr > td > input').remove();
                    $('.clone-facturas').html(table);

                    $('.Ccomprobante').html($('#nombreComprobante option:selected').html());
                    $('.Cfecha-comprobante').html($('#fechaFactura').val());
                    $('.Ccliente > span').html($('#clientes option:selected').html());
                    $('.Ccliente-rfc > span').html($('.cliente-rfc').val());
                    $('.Ccliente-razonSocial > span').html($('.cliente-razonSocial').val());
                    $('.Ccliente-calle > span').html($('.cliente-calle').val());
                    $('.Ccliente-noExt > span').html($('.cliente-noExt').val());
                    $('.Ccliente-noInt > span').html($('.cliente-noInt').val());
                    $('.Ccliente-colonia > span').html($('.cliente-colonia').val());
                    $('.Ccliente-municipio > span').html($('.cliente-municipio').val());
                    $('.Ccliente-localidad > span').html($('.cliente-localidad').val());
                    $('.Ccliente-estado > span').html($('.cliente-estado').val());
                    $('.Ccliente-codigoPostal > span').html($('.cliente-codigoPostal').val());
                    $('.Ccliente-pais > span').html($('.cliente-pais').val());
                    $('.Ccliente-telefono > span').html($('.cliente-telefono').val());
                    $('.Ccliente-nombreContacto > span').html($('.cliente-nombreContacto').val());
                    $('.Ccliente-email > span').html($('.cliente-email').val());
                break;
            }
        },
        afterSelect: function( event, state ) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
        }
    });

    $('.btn-agregar').click(function(event) {
        event.preventDefault();
        var ob = $(this).closest('.clone');
        var table = $('.table-productos');
        var claveProdServ = $('#hclave-prod-serv').val();
        var claveUnidad = $('#hclave-unidad').val();
        var unidadProducto = $('#unidad_producto').val();
        var claveProducto = $('#clave_producto').val();
        var descripcionProducto = $('#descripcion_producto').val();

        var inputClaveProdServ = '<input type="hidden" name="claves-prods-servs[]" value="' + claveProdServ + '">';
        var inputClaveUnidad = '<input type="hidden" name="claves-unidades[]" value="' + claveUnidad + '">';
        var inputUnidadProductos = '<input type="hidden" name="productos-unidad[]" value="' + unidadProducto + '">';
        var inputClaveProductos = '<input type="hidden" name="productos-clave[]" value="' + claveProducto + '">';
        var inputDescripcionProductos = '<input type="hidden" name="productos-descripcion[]" value="' + descripcionProducto + '">';
        var inputCantidad = '<input type="hidden" class="cantidad" name="cantidad[]" value="' + ob.find('#cantidad').val() + '">';

        var prod = ob.find('#clave_producto').val() + " - " + ob.find('#descripcion_producto').val()
        var fila = '<tr>';
        fila += '<td>' + inputUnidadProductos + inputClaveProductos + inputDescripcionProductos + prod + '</td>';
        fila += '<td>' + inputClaveProdServ + $('#hclave-prod-serv-text').val() + '</td>';
        fila += '<td>' + inputClaveUnidad + $('#hclave-unidad-text').val() + '</td>';
        fila += '<td>' + inputCantidad + ob.find('#cantidad').val() + '</td>';
        fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-producto btn btn-danger"><i class="icon-cross" aria-hidden="true"></i></a></td>';
        fila += '</tr>';

        table.find('tbody').append(fila);
        table.find('tr:last').find('.delete-producto').click(function(event) {
            event.preventDefault();
            var ob = $(this).closest('tr');
            ob.remove();
        });
    });

    $('.btn-agregar-factura').click(function(event) {
        event.preventDefault();
        var ob = $(this).closest('.clone');
        var table = $('.table-facturas');
        var metodoPagoDR = $('#metodo-pago-dr').val();
        var numeroParcialidad = $('#numero-parcialidad').val();
        var saldoAnterior = $('#saldo-anterior').val();
        var importePagado = $('#importe-pagado').val();
        var retencionIva = $('#retencion-iva').val();
        var retencionIsr = $('#retencion-isr').val();
        var retencionIeps = $('#retencion-ieps').val();
        var trasladoIva = $('#traslado-iva').val();
        var trasladoIsr = $('#traslado-isr').val();
        var trasladoIeps = $('#traslado-ieps').val();
        var uuid = ob.find('#facturas option:selected').html();

        var inputMetodoPagoDR = '<input type="hidden" name="metodos-pagos-dr[]" value="' + metodoPagoDR + '">';
        var inputNumeroParcialidad = '<input type="hidden" name="numeros-parcialidades[]" value="' + numeroParcialidad + '">';
        var inputSaldoAnterior = '<input type="hidden" name="saldos-anteriores[]" value="' + saldoAnterior + '">';
        var inputImportePagado = '<input type="hidden" name="importes-pagados[]" value="' + importePagado + '">';
        var inputRetencionIva = '<input type="hidden" name="retenciones-iva[]" value="' + retencionIva + '">';
        var inputRetencionIsr = '<input type="hidden" name="retenciones-isr[]" value="' + retencionIsr + '">';
        var inputRetencionIeps = '<input type="hidden" name="retenciones-ieps[]" value="' + retencionIeps + '">';
        var inputTrasladoIva = '<input type="hidden" name="traslado-iva[]" value="' + trasladoIva + '">';
        var inputTrasladoIsr = '<input type="hidden" name="traslado-isr[]" value="' + trasladoIsr + '">';
        var inputTrasladoIeps = '<input type="hidden" name="traslado-ieps[]" value="' + trasladoIeps + '">';
        var inputUuid = '<input type="hidden" name="uuids[]" value="' + uuid + '">';

        var fila = '<tr>';
        fila += '<td>' + uuid + inputUuid + inputMetodoPagoDR + inputNumeroParcialidad + inputRetencionIva + inputRetencionIsr + inputRetencionIeps + inputTrasladoIva + inputTrasladoIsr + inputTrasladoIeps + '</td>';
        fila += '<td>' + inputSaldoAnterior + $('#saldo-anterior').val() + '</td>';
        fila += '<td>' + inputImportePagado + $('#importe-pagado').val() + '</td>';
        fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-factura btn btn-danger"><i class="icon-cross" aria-hidden="true"></i></a></td>';
        fila += '</tr>';

        table.find('tbody').append(fila);
        table.find('tr:last').find('.delete-factura').click(function(event) {
            event.preventDefault();
            var ob = $(this).closest('tr');
            ob.remove();
        });
    });

    $('#productos').change(function(event) {
        if ($(this).val() !== null) {
            fnsGenerales.fnAJAX('/productos/info/' + $(this).val(), 'GET', {}, 'JSON', null, function(response, success) {
                if (success && response.success) {
                    $('#precio').val(response.data.precio);
                    $('#unidad_producto').val(response.data.unidad);
                    $('#clave_producto').val(response.data.clave);
                    $('#descripcion_producto').val(response.data.descripcion);
                    $('#observaciones_producto').val(response.data.observaciones);
                    $('#clave-prod-serv').attr('data-id', response.data.claveProdServ.id);
                    $('#clave-prod-serv').attr('data-text', response.data.claveProdServ.descripcion);
                    $('#clave-unidad').attr('data-id', response.data.claveUnidad.id);
                    $('#clave-unidad').attr('data-text', response.data.claveUnidad.descripcion);
                    $('#hclave-prod-serv').val(response.data.claveProdServ.id);
                    $('#hclave-unidad').val(response.data.claveUnidad.id);
                    $('#hclave-prod-serv-text').val(response.data.claveProdServ.descripcion.substring(0, 15));
                    $('#hclave-unidad-text').val(response.data.claveUnidad.descripcion.substring(0, 15));
                    $('#descuento_producto').val(0.00);
                    // if (!flagSelect) {
                        fnsGenerales.select2AJAX('#clave-prod-serv', $('#clave-prod-serv').data('url'), $('#clave-prod-serv').data('id'), $('#clave-prod-serv').data('text'));
                        fnsGenerales.select2AJAX('#clave-unidad', $('#clave-unidad').data('url'), $('#clave-unidad').data('id'), $('#clave-unidad').data('text'));
                        $('#clave-prod-serv').on('select2:select', function(e) {
                            $('#hclave-prod-serv').val(e.params.data.id);
                            $('#hclave-prod-serv-text').val(e.params.data.text);
                        });

                        $('#clave-unidad').on('select2:select', function(e) {
                            $('#hclave-unidad').val(e.params.data.id);
                            $('#hclave-unidad-text').val(e.params.data.text);
                        });
                    // }
                }
            });
        }
    }).trigger('change');
})
