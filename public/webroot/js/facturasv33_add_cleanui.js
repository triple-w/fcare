$(function(){

    $('.cont').on('click', 'div.clone > a.btn-clone', function(event) {
        event.preventDefault();

        var toClone = $(this).closest('.clone').clone();
        if (toClone.find('a.btn-eliminar-clone').length == 0) {
            toClone.append('<a href="#" class="btn btn-danger btn-eliminar-clone">Eliminar</a>')
        }

        $(this).closest('div.cont').append('<div class="clone">' + toClone.html() + '</div>');
    });

    $('.cont').on('click', 'div.clone > a.btn-eliminar-clone', function(event) {
        event.preventDefault();

        $(this).closest('div.clone').remove();
    });

    $('.cont-tipo-moneda').hide();
    $('#select-tipo-moneda').change(function(event) {
        if ($(this).val() !== 'MXN') {
            $('.cont-tipo-moneda').show();
        } else {
            $('.cont-tipo-moneda').hide();
        }
    });

    $('.btn-clone-first').click(function(event) {
        // $(this).closest('.cont').append('<div class="clone"><div class="form-group "><label for="tipoImpuestosRet[]" class="control-label">Nombre de Impuesto Retenido</label><div><input class="form-control" id="tipoImpuestosRet[]" name="tipoImpuestosRet[]" type="text"></div></div>' + '<div class="form-group "><label for="valorImpuestosRet[]" class="control-label">Valor de impuesto Retenido (%)</label><div><input class="form-control" id="valorImpuestosRet[]" name="valorImpuestosRet[]" type="text"></div></div>' + '<a href="#" class="btn btn-default btn-clone"> Agregar Impuesto</a>' + '<a href="#" class="btn btn-danger btn-eliminar-clone">Eliminar</a></div>');
    });

    $('#actualizar-cliente').click(function(event) {
        event.preventDefault();
        // var data = "";
        $.each($('.recolect-cliente'), function(key, value) {
            var ob = $(value);
            $('#form-agregar-cliente').find('input[name="' + ob.attr('name') + '"]').val(ob.val());
            // data += ob.attr('name') + '=' + ob.val() + '&';
        });
        $('#form-agregar-cliente').find('input[name="tipo"]').val('update');
        var id = $('#clientes').val();
        $('#form-agregar-cliente').find('input[name="id"]').val(id);
        $('#modal-add-cliente').modal('show');
    });

    $('#nuevo-cliente').click(function(event) {
        event.preventDefault();
        $('#form-agregar-cliente').find('input[name="tipo"]').val('insert');
        $('#form-agregar-cliente').find('input[name="id"]').val('');
        $('#modal-add-cliente').modal('show');
    });

    $('#form-agregar-cliente').validate({
        submit: {
            settings: {
                inputContainer: '.form-group',
                errorListClass: 'form-control-error',
                errorClass: 'has-danger'
            },
            callback: {
                onSubmit: function(node, formData) {
                    $('div.mensaje-cliente').html('');
                    switch (node.find('input[name="tipo"]').val()) {
                        case 'update':
                            var id = node.find('input[name="id"]').val()
                            fnsGenerales.fnAJAX('/clientes/edit/' + id, 'POST', node.serialize(), 'JSON', null, function(response, success) {
                                if (success && response.success) {
                                    fnsGenerales.loadSelectClientes('.mensaje-cliente-editar');
                                    node.trigger("reset");
                                }
                            });
                        break;
                        case 'insert':
                            fnsGenerales.fnAJAX('/clientes/add', 'POST', node.serialize(), 'JSON', null, function(response, success) {
                                if (success && response.success) {
                                    fnsGenerales.loadSelectClientes('.mensaje-cliente-agregar');
                                    node.trigger("reset");
                                }
                            });
                        break;
                    }
                    return false;
                }
            }
        }
    });

    $('#clientes').change(function(event) {
        $('div.mensaje-cliente').html('');
        if ($('#clientes').val() !== null) {
            fnsGenerales.fnAJAX('/clientes/info/' + $('#clientes').val(), 'GET', {}, 'JSON', null, function(response, success) {
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
                    if ($('.cliente-rfc').val() === '') {
                        $('div.mensaje-cliente').html('Porfavor agrega al menos un cliente');
                        return false;
                    }
                break;
                case 3:
                    if ($('div.cont > div.table-responsive > table.table-productos > tbody > tr').length <= 0) {
                        $('div.mensaje').html('Porfavor agrega al menos un producto');
                        return false;
                    }
                break;
                case 4:
                    if ($('.forma-pago').val() == "") {
                        $('div.mensaje-pago').html('Porfavor llena este campo');
                        return false;
                    }

                    $('.clone-productos').html('');

                    var table = $('.table-productos').clone();
                    table.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                    table.find('tbody > tr > td > input').remove();
                    $('.clone-productos').html(table);

                    $('.Cforma-pago > span').html($('.forma-pago').val());
                    $('.Ctipo-moneda > span').html($('#select-tipo-moneda').val());
                    $('.Ctipo-cambio > span').html($('#select-tipo-moneda').val() === 'MXN' ? 1 : $('.tipo-moneda').val());
                    $('.Cmetodo-pago > span').html($('.metodo-pago').val());
                    $('.Cnumero-cuenta > span').html($('.numero-cuenta').val());

                    $('.Csubtotal > span').html($('.subtotal > span').html());
                    var descuento = 0;
                    var totalTrasladado = 0;
                    var totalRetenido = 0;
                    var importe = 0;
                    $.each($('div.clone-productos > table.table-productos > tbody > tr'), function(key, value) {
                        importe += parseFloat($(value).find('td:eq(7)').html());
                        totalTrasladado += parseFloat($(value).find('.htraslados-total').val());
                        totalRetenido += parseFloat($(value).find('.hretenciones-total').val());
                        descuento += parseFloat($(value).find('td:eq(5)').html());
                    });

                    var nuevoSubTotal = subtotal - descuento;
                    $('.Cnuevo-subtotal > span').html(nuevoSubTotal.toFixed(2));
                    $('.subtotal > span').html(nuevoSubTotal.toFixed(2))

                    var total = (importe + totalTrasladado) - descuento - totalRetenido;

                    $('.Ctotal-trasladado > span').html(totalTrasladado.toFixed(2));
                    $('.Ctotal-retenido > span').html(totalRetenido.toFixed(2));
                    $('.Cdescuento > span').html(descuento.toFixed(2));
                    $('.Ctotal > span').html(total.toFixed(2));

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

    $('.forma-pago').keyup(function(event) {
        $('div.mensaje-pago').html('');
    });

    $('select').select2();

    var flagSelect = false;
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

    $('.mas-retencion').click(function(event) {
        event.preventDefault();
        var ob = $('.rete').clone();
        ob.find('.mas-retencion').remove();

        $('.contenedor-retenciones').append('<div class="row rete-clone">' + ob.html() + '<a href="#" class="delete-retencion">-</a></div>');
    });

    $('.contenedor-retenciones').on('click', 'div.rete-clone > a.delete-retencion', function(event) {
        event.preventDefault();
        $(this).closest('.rete-clone').remove();
    });

    $('.mas-traslado').click(function(event) {
        event.preventDefault();
        var ob = $('.tras').clone();
        ob.find('.mas-traslado').remove();

        $('.contenedor-traslados').append('<div class="row tras-clone">' + ob.html() + '<a href="#" class="delete-traslado">-</a></div>');
    });

    $('.contenedor-traslados').on('click', 'div.tras-clone > a.delete-traslado', function(event) {
        event.preventDefault();
        $(this).closest('.tras-clone').remove();
    });

    var subtotal = 0;
    var contadorGlobal = 0;
    $('.btn-agregar').click(function(event) {
        event.preventDefault();
        var ob = $(this).closest('.clone');
        var table = $('.table-productos');
        var claveProdServ = $('#hclave-prod-serv').val();
        var claveUnidad = $('#hclave-unidad').val();
        var unidadProducto = $('#unidad_producto').val();
        var claveProducto = $('#clave_producto').val();
        var descripcionProducto = $('#descripcion_producto').val();
        var observacionesProducto = $('#observaciones_producto').val();
        var valorPrecio = parseFloat(ob.find('#precio').val()).toFixed(2);
        var descuento = parseFloat(ob.find('#descuento_producto').val()).toFixed(2);

        var inputClaveProdServ = '<input type="hidden" name="claves-prods-servs[]" value="' + claveProdServ + '">';
        var inputClaveUnidad = '<input type="hidden" name="claves-unidades[]" value="' + claveUnidad + '">';
        var inputUnidadProductos = '<input type="hidden" name="productos-unidad[]" value="' + unidadProducto + '">';
        var inputClaveProductos = '<input type="hidden" name="productos-clave[]" value="' + claveProducto + '">';
        var inputDescripcionProductos = '<input type="hidden" name="productos-descripcion[]" value="' + descripcionProducto + '">';
        var inputObservacionesProductos = '<input type="hidden" name="productos-observaciones[]" value="' + observacionesProducto + '">';
        var inputPrecio = '<input type="hidden" class="precios" name="precios[]" value="' + valorPrecio + '">';
        var inputCantidad = '<input type="hidden" class="cantidad" name="cantidad[]" value="' + ob.find('#cantidad').val() + '">';
        var inputTipoImpuesto = '<input type="hidden" class="productos-tipo-impuesto" name="productos-tipo-impuesto[]" value="' + ob.find('#tipo-impuesto').val() + '">';
        var inputDescuento = '<input type="hidden" class="descuentos" name="descuentos[]" value="' + descuento + '">';


        $('div.mensaje-precio').html('');
        $('div.mensaje-cantidad').html('');

        var valid = true;
        if (!$.isNumeric(ob.find('#precio').val())) {
            $('div.mensaje-precio').html('El precio debe ser numerico');
            valid = false;
        } else {
            if (ob.find('#precio').val() <= 0) {
                $('div.mensaje-precio').html('El precio debe ser mayor a 0');
                valid = false;
            }
        }

        if (!$.isNumeric(ob.find('#cantidad').val())) {
            $('div.mensaje-cantidad').html('La cantidad debe ser numerico');
            valid = false;
        } else {
            if (ob.find('#cantidad').val() <= 0) {
                $('div.mensaje-cantidad').html('La cantidad debe ser mayor a 0');
                valid = false;
            }
        }

        if (!valid) {
            return false;
        }

        var precio = 0;
        precio = ob.find('#tipo-impuesto').val() == 1 ? (ob.find('#precio').val() / 1.16) : ob.find('#precio').val();
        var importe = parseFloat(precio * ob.find('#cantidad').val());
        subtotal += importe;
        var iva = ob.find('#tipo-impuesto').val() == 1 ? (ob.find('#precio').val() - precio) * ob.find('#cantidad').val() : (ob.find('#precio').val() * .16) * ob.find('#cantidad').val()

        var retenciones = "";
        var totRetenciones = 0;
        $.each($('.retenciones-tasa'), function(key, index) {
            var val = $(this).val();
            retenciones += '<input type="hidden" class="hretenciones-tasa" name="retenciones-tasap[' + contadorGlobal + '][' + key + ']" value="' + val + '">';
            var tipo = $('.retenciones-tipo').eq(key).val();
            retenciones += '<input type="hidden" class="hretenciones-tipo" name="retenciones-tipop[' + contadorGlobal + '][' + key + ']" value="' + tipo + '">';
            if (val !== "") {
                totRetenciones += (importe * (parseFloat(val) / 100)).toFixed(2);
            }
        });
        retenciones += '<input type="hidden" class="hretenciones-total" name="total-retenciones" value="' + totRetenciones  + '">';

        var traslados = "";
        var totTraslados = 0;
        $.each($('.traslados-tasa'), function(key, index) {
            var val = $(this).val();
            traslados += '<input type="hidden" class="htraslados-tasa" name="traslados-tasap[' + contadorGlobal + '][' + key + ']" value="' + val + '">';
            var tipo = $('.traslados-tipo').eq(key).val() ;
            traslados += '<input type="hidden" class="htraslados-tipo" name="traslados-tipop[' + contadorGlobal + '][' + key + ']" value="' + tipo + '">';
            if (val !== "") {
                totTraslados += (importe * (parseFloat(val) / 100)).toFixed(2);
            }
        });
        traslados += '<input type="hidden" class="htraslados-total" name="total-traslados" value="' + totTraslados  + '">';
        contadorGlobal++;

        var tipoImpuesto = '<span class="label label-default">Desglosado</span>';
        if (ob.find('#tipo-impuesto').val() === '0') {
            var tipoImpuesto = '<span class="label label-default">No Desglosado</span>';
        }

        var prod = ob.find('#clave_producto').val() + " - " + ob.find('#descripcion_producto').val()
        var fila = '<tr>';
        fila += '<td>' + inputClaveProdServ + $('#hclave-prod-serv-text').val() + '</td>';
        fila += '<td>' + inputClaveUnidad + $('#hclave-unidad-text').val() + '</td>';
        fila += '<td>' + inputUnidadProductos + inputClaveProductos + inputDescripcionProductos + prod + '</td>';
        fila += '<td>' + inputCantidad + ob.find('#cantidad').val() + '</td>';
        fila += '<td>' + inputPrecio + valorPrecio + '</td>';
        fila += '<td>' + inputDescuento + descuento + '</td>';
        fila += '<td>' + inputTipoImpuesto + tipoImpuesto + '</td>';
        // fila += '<td>' + iva.toFixed(2) + '</td>';
        fila += '<td>' + importe.toFixed(2) + '</td>';
        fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-producto btn btn-danger"><i class="icmn-cross" aria-hidden="true"></i></a></td>';
        fila += retenciones;
        fila += traslados;
        fila += '</tr>';

        table.find('tbody').append(fila);
        $('.rete-clone').remove();
        $('.tras-clone').remove();
        $('div.mensaje').html('');

        var valorIva = iva + parseFloat($('.valor-iva').val());
        $('.valor-iva').val(valorIva.toFixed(2));

        $('.subtotal > span').html(subtotal.toFixed(2));

        if (subtotal > 0) {
            $('.subtotal').show();
        }

        table.find('tr:last').find('.delete-producto').click(function(event) {
            event.preventDefault();
            var ob = $(this).closest('tr');
            subtotal -= ob.find('td:eq(4)').html();

            var precio = 0;
            precio = ob.find('.productos-tipo-impuesto').val() == 1 ? (ob.find('.precios').val() / 1.16) : ob.find('.precios').val();
            var iva = ob.find('.productos-tipo-impuesto').val() == 1 ? (ob.find('.precios').val() - precio) * ob.find('.cantidad').val() : (ob.find('.precios').val() * .16) * ob.find('.cantidad').val();

            var totalIva = $('.valor-iva').val() - parseFloat(iva);
            $('.valor-iva').val(totalIva.toFixed(2));

            $('.subtotal > span').html(subtotal.toFixed(2));

            if (subtotal <= 0) {
                $('.subtotal').hide();
            }

            ob.remove();
        });

    });

    $('.descuento').keyup(function(event) {
        var subtotal = parseFloat($('.subtotal > span').html());
        var inputTipoDescuento = $('input[name=tipoDescuento]');
        tipoDescuento = inputTipoDescuento.filter(':checked').val();
        if (tipoDescuento === 'porcentaje') {
            if ($('.descuento').val() != "") {
                descuento = parseFloat($('.descuento').val());
                descuento = subtotal * (descuento / 100);
            }
        } else {
            descuento = $('.descuento').val();
        }
        var nuevoSubtotal = subtotal - descuento;
        var valorIva = nuevoSubtotal * ($('.iva-trasladado').val() / 100);
        $('.valor-iva').val(valorIva.toFixed(2));
    });

    $('.iva-trasladado').keyup(function(event) {
        var subtotal = parseFloat($('.subtotal > span').html());
        var inputTipoDescuento = $('input[name=tipoDescuento]');
        tipoDescuento = inputTipoDescuento.filter(':checked').val();
        if (tipoDescuento === 'porcentaje') {
            if ($('.descuento').val() != "") {
                descuento = parseFloat($('.descuento').val());
                descuento = subtotal * (descuento / 100);
            }
        } else {
            descuento = $('.descuento').val();
        }
        var nuevoSubtotal = subtotal - descuento;

        var valorIva = nuevoSubtotal * ($('.iva-trasladado').val() / 100);
        $('.valor-iva').val(valorIva.toFixed(2));
    });

})
