$(function(){

    var fnsGenerales = {
        fnAJAX: function (url, type, data, dataType, contentType, callBack) {
            url = $('#url-public').attr('value') + url;
            if (contentType === null) {
                contentType = "application/x-www-form-urlencoded; charset=UTF-8";
            }
            $.ajax({
                url: url,
                type: type,
                data: data,
                datatype: dataType,
                cache: false,
                processData: false,
                contentType: contentType,
                beforeSend: function (jqXHR, settings) {
                    return jqXHR.setRequestHeader('X-CSRF-TOKEN', $('#csrf-token').attr('value'));
                },
                success: function (response, textStatus, jqXHR) {
                    // if (jqXHR.getResponseHeader('REQUIRES_AUTH') === '1') {
                    //     window.location.href = jqXHR.getResponseHeader('LOCATION');
                    // }
                    if ($.type(callBack) === "function") {
                        callBack(response, true);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if ($.type(callBack) === "function") {
                        callBack(jqXHR.responseText, false);
                    }
                },
                complete: function (jqXHR, textStatus) {
                    // if ($.type(callBackLoading) === "function") {
                    //     callBackLoading(false);
                    // }
                }
            });
        },
        loadSelectClientes: function(mensajeDiv) {
            var chosen = $('#clientes').val();
            fnsGenerales.fnAJAX('/clientes/index', 'GET', {}, 'JSON', null, function(response, success) {
                if (success && response.success) {
                    var options = "";
                    var chosenHTML = ""
                    var tipo = $('#form-agregar-cliente').find('input[name="tipo"]').val();
                    $.each(response.data, function(key, value) {
                        var text = value.razonSocial + " - " + value.rfc;
                        if (chosenHTML === '') {
                            chosenHTML = value.id == chosen ? text : '';
                        }
                        options += "<option value='" + value.id + "' " +  ((value.id == chosen && tipo === 'update') ? 'selected' : '') + ">" + text + "</option>";
                    });

                    $('#clientes').html(options)
                    if (tipo === 'insert') {
                        $('#clientes').val($('#clientes option:last').val());
                        chosenHTML = $('#clientes option:last').html();
                    }
                    $('#clientes').trigger('change');
                    $('#modal-add-cliente').modal('hide');
                    $('.select2-chosen').html(chosenHTML);
                    // $(mensajeDiv).show();
                    // setTimeout(function() {
                    //  $('.mensaje-cliente-agregar').hide();
                    //  $('.mensaje-cliente-editar').hide();
                    // }, 2000);
                }
            });
        }
    };

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
                    $('div.mensaje-comentarios').html('')
                    if ($('.forma-pago').val() == "") {
                        $('div.mensaje-pago').html('Porfavor llena este campo');
                        return false;
                    }

                    if ($('.comentarios-pdf').val().length > 250) {
                        $('div.mensaje-comentarios').html('El maximo es de 250 caracteres');
                        return false;   
                    }

                    $('.clone-productos').html('');

                    var table = $('.table-productos').clone();
                    table.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                    table.find('tbody > tr > td > input').remove();
                    $('.clone-productos').html(table);

                    $('.clone-table-impuestos').html('');

                    var table = $('#table-impuestos').clone();
                    if (table.find('tbody > tr').length > 0) {
                        table.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                        table.find('tbody > tr > td > input').remove();
                        $('.clone-table-impuestos').html(table);
                    }

                    $('.Civa-trasladado > span').html($('.iva-trasladado').val());
                    $('.Cvalor-iva > span').html($('.valor-iva').val());
                    $('.Cieps-trasladado > span').html($('.ieps-trasladado').val());
                    $('.Civa-retenido > span').html($('.iva-retenido').val());
                    $('.Cisr-retenido > span').html($('.isr-retenido').val());

                    $('.Cforma-pago > span').html($('.forma-pago').val());
                    $('.Ctipo-moneda > span').html($('#select-tipo-moneda').val());
                    $('.Ctipo-cambio > span').html($('#select-tipo-moneda').val() === 'MXN' ? 1 : $('.tipo-moneda').val());
                    $('.Cmetodo-pago > span').html($('.metodo-pago').val());
                    $('.Cnumero-cuenta > span').html($('.numero-cuenta').val());

                    $('.Csubtotal > span').html($('.subtotal > span').html());
                    $('.Cmotivo-descuento > span').html($('.motivo-descuento').val());
                    var descuento = 0;
                    var subtotal = parseFloat($('.subtotal > span').html());
                    var inputTipoDescuento = $('input[name=tipoDescuento]');
                    tipoDescuento = inputTipoDescuento.filter(':checked').val();
                    if (tipoDescuento === 'porcentaje') {
                        if ($('.descuento').val() != "") {
                            descuento = parseFloat($('.descuento').val());
                            descuento = subtotal * (descuento / 100);
                        }
                    } else {
                        descuento = parseFloat($('.descuento').val());
                    }
                    $('.Cdescuento > span').html(descuento.toFixed(3));
                    var nuevoSubTotal = subtotal - descuento;
                    $('.Cnuevo-subtotal > span').html(nuevoSubTotal.toFixed(3));
                    $('.subtotal > span').html(nuevoSubTotal.toFixed(3))

                    var importe = 0;
                    $.each($('div.clone-productos > table.table-productos > tbody > tr'), function(key, value) {
                        importe += parseFloat($(value).find('td:eq(4)').html());
                    });
                    var ivaTrasladado = parseFloat($('.valor-iva').val());
                    var iepsTrasladado = $('.ieps-trasladado-valor').val() !== "" ? parseFloat($('.ieps-trasladado-valor').val()) : 0 ;
                    var ivaRetenido = 0;
                    var isrRetenido = 0;
                    var valIvaRetenido = $('.iva-retenido').val() !== "" ? parseFloat($('.iva-retenido').val()) : 0;
                    if (valIvaRetenido > 0) {
                        ivaRetenido = (valIvaRetenido / 100) * nuevoSubTotal;
                    }
                    var valIsrRetenido = $('.isr-retenido').val() !== "" ? parseFloat($('.isr-retenido').val()) : 0;
                    if (valIsrRetenido) {
                        isrRetenido = (valIsrRetenido / 100) * nuevoSubTotal;
                    }

                    var totalTrasladado = 0;
                    var totalRetenido = 0;
                    $.each($('div.clone-table-impuestos > table.table-impuestos > tbody > tr'), function(key, value) {
                        var t = $(value).find('td:eq(1)').html();
                        if (t === 'TRASLADO') {
                            var v = parseFloat($(value).find('td:eq(2)').html());
                            totalTrasladado += (v / 100) * nuevoSubTotal;
                        } else {
                            var v = parseFloat($(value).find('td:eq(2)').html());
                            totalRetenido += (v / 100) * nuevoSubTotal;
                        }
                    });

                    var total = (importe + ivaTrasladado + iepsTrasladado + totalTrasladado) - descuento - ivaRetenido - isrRetenido - totalRetenido;

                    $('.Ctotal > span').html(total.toFixed(3));

                    $('.Ccomprobante').html($('#nombreComprobante option:selected').html());
                    $('.Cfecha-comprobante').html($('#fechaFactura').val());
                    // $('.Ccomprobante').html('prueba');
                    // $('.Cfecha-comprobante').html('prueba');
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


                    // var direccionReceptor = $('.cliente-noExt').val() + ' ' + $('.cliente-calle').val() + '<br />' + $('.cliente-municipio').val() + ' ' + $('.cliente-estado').val() + ' ' + $('.cliente-codigoPostal').val() + '<br />' + '<abbr title="Phone">TEL:</abbr> ' + $('.cliente-telefono').val();
                    // $('.direccion-receptor').html(direccionReceptor);

                    // var direccionEmisor = $('.cliente-noExt').val() + ' ' + $('.cliente-calle').val() + '<br />' + $('.cliente-municipio').val() + ' ' + $('.cliente-estado').val() + ' ' + $('.cliente-codigoPostal').val() + '<br />' + '<abbr title="Phone">TEL:</abbr> ' + $('.cliente-telefono').val();
                    // $('.direccion-receptor').html(direccion);
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

    $('#productos').change(function(event) {
        if ($(this).val() !== null) {
            fnsGenerales.fnAJAX('/productos/info/' + $(this).val(), 'GET', {}, 'JSON', null, function(response, success) {
                if (success && response.success) {
                    $('#precio').val(response.data.precio);
                    $('#unidad_producto').val(response.data.unidad);
                    $('#clave_producto').val(response.data.clave);
                    $('#descripcion_producto').val(response.data.descripcion);
                    $('#observaciones_producto').val(response.data.observaciones);
                }
            });
        }
    }).trigger('change');

    $('.btn-agregar-impuesto').click(function(event) {
        event.preventDefault();
        var table = $('.table-impuestos');
        var select = $('#nImpuestos');
        var option = select.find('option:selected').html();
        if (option !== "") {
            var arr = option.split('-');
            var nombre = arr[0];
            var tasa = arr[1];
            var tipo = arr[2];

            var fila = '<tr>';
            fila += '<td>';
            fila += '<input type="hidden" name="nuevosImpuestosNombre[]" value="' + nombre + '" />' + nombre;
            fila += '</td>';
            fila += '<td>';
            fila += '<input type="hidden" name="nuevosImpuestosTipo[]" value="' + tipo + '" />' + tipo;
            fila += '</td>';
            fila += '<td>';
            fila += '<input type="hidden" name="nuevosImpuestosTasa[]" value="' + tasa + '" />' + tasa;
            fila += '</td>';
            fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-producto btn btn-danger"><i class="icmn-cross" aria-hidden="true"></i></a></td>';
            fila += '</tr>';

            table.find('tbody').append(fila);

            table.find('tr:last').find('.delete-producto').click(function(event) {
                event.preventDefault();
                var ob = $(this).closest('tr');
                ob.remove();
            });
        }

    });

    var subtotal = 0;
    $('.btn-agregar').click(function(event) {
        event.preventDefault();
        var ob = $(this).closest('.clone');
        var table = $('.table-productos');
        var unidadProducto = $('#unidad_producto').val();
        var claveProducto = $('#clave_producto').val();
        var descripcionProducto = $('#descripcion_producto').val();
        var observacionesProducto = $('#observaciones_producto').val();
        var valorPrecio = parseFloat(ob.find('#precio').val());

        var inputUnidadProductos = '<input type="hidden" name="productos-unidad[]" value="' + unidadProducto + '">';
        var inputClaveProductos = '<input type="hidden" name="productos-clave[]" value="' + claveProducto + '">';
        var inputDescripcionProductos = '<input type="hidden" name="productos-descripcion[]" value="' + descripcionProducto + '">';
        var inputObservacionesProductos = '<input type="hidden" name="productos-observaciones[]" value="' + observacionesProducto + '">';
        var inputPrecio = '<input type="hidden" class="precios" name="precios[]" value="' + valorPrecio + '">';
        var inputCantidad = '<input type="hidden" class="cantidad" name="cantidad[]" value="' + ob.find('#cantidad').val() + '">';
        var inputTipoImpuesto = '<input type="hidden" class="productos-tipo-impuesto" name="productos-tipo-impuesto[]" value="' + ob.find('#tipo-impuesto').val() + '">';

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
        var importe = precio * ob.find('#cantidad').val();
        subtotal += parseFloat(importe);
        var iva = ob.find('#tipo-impuesto').val() == 1 ? (ob.find('#precio').val() - precio) * ob.find('#cantidad').val() : (ob.find('#precio').val() * .16) * ob.find('#cantidad').val()

        var tipoImpuesto = '<span class="label label-default">Desglosado</span>';
        if (ob.find('#tipo-impuesto').val() === '0') {
            var tipoImpuesto = '<span class="label label-default">No Desglosado</span>';
        }

        var prod = ob.find('#clave_producto').val() + " - " + ob.find('#descripcion_producto').val()
        var fila = '<tr>';
        fila += '<td>' + inputUnidadProductos + inputClaveProductos + inputDescripcionProductos + prod + '</td>';
        fila += '<td>' + inputCantidad + ob.find('#cantidad').val() + '</td>';
        fila += '<td>' + inputPrecio + valorPrecio.toFixed(3) + '</td>';
        fila += '<td>' + inputTipoImpuesto + tipoImpuesto + '</td>';
        // fila += '<td>' + iva.toFixed(2) + '</td>';
        fila += '<td>' + importe.toFixed(3) + '</td>';
        fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-producto btn btn-danger"><i class="icmn-cross" aria-hidden="true"></i></a></td>';
        fila += '</tr>';

        table.find('tbody').append(fila);
        $('div.mensaje').html('');

        var valorIva = iva + parseFloat($('.valor-iva').val());
        $('.valor-iva').val(valorIva.toFixed(3));

        $('.subtotal > span').html(subtotal.toFixed(3));

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
            $('.valor-iva').val(totalIva.toFixed(3));

            $('.subtotal > span').html(subtotal.toFixed(3));

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
        $('.valor-iva').val(valorIva.toFixed(3));
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
        $('.valor-iva').val(valorIva.toFixed(3));
    });

})
