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
        loadSelectEmpleados: function(mensajeDiv) {
            var chosen = $('#empleados').val();
            fnsGenerales.fnAJAX('/empleados/index', 'GET', {}, 'JSON', null, function(response, success) {
                if (success && response.success) {
                    var options = "";
                    var chosenHTML = ""
                    var tipo = $('#form-agregar-empleado').find('input[name="tipo"]').val();
                    $.each(response.data, function(key, value) {
                        var text = value.nombre + " - " + value.rfc;
                        if (chosenHTML === '') {
                            chosenHTML = value.id == chosen ? text : '';
                        }
                        options += "<option value='" + value.id + "' " +  ((value.id == chosen && tipo === 'update') ? 'selected' : '') + ">" + text + "</option>";
                    });

                    $('#empleados').html(options)
                    if (tipo === 'insert') {
                        $('#empleados').val($('#empleados option:last').val());
                        chosenHTML = $('#empleados option:last').html();
                    }
                    $('#empleados').trigger('change');
                    $('#modal-add-empleado').modal('hide');
                    $('.select2-chosen').html(chosenHTML);
                }
            });
        }
    };

    $("#progressbar").progressbar();

    $('#form-wizard').wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function( event, state ) {
            switch (state.stepIndex) {
                case 1:
                break;
                case 5:
                    var tablePercepciones = $('.table-percepciones').clone();
                    tablePercepciones.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                    tablePercepciones.find('tbody > tr > td > input').remove();
                    tablePercepciones.removeClass('table-percepciones');

                    var tableDeducciones = $('.table-deducciones').clone();
                    tableDeducciones.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                    tableDeducciones.find('tbody > tr > td > input').remove();
                    tableDeducciones.removeClass('table-deducciones');

                    var tableOtrosPagos = $('.table-otros-pagos').clone();
                    tableOtrosPagos.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                    tableOtrosPagos.find('tbody > tr > td > input').remove();
                    tableOtrosPagos.removeClass('table-otros-pagos');

                    $('.resumen-percepciones').html();
                    $('.resumen-percepciones').html(tablePercepciones);
                    $('.resumen-deducciones').html();
                    $('.resumen-deducciones').html(tableDeducciones);
                    $('.resumen-otros-pagos').html();
                    $('.resumen-otros-pagos').html(tableOtrosPagos);

                    var totalPercepciones = 0.00;
                    var totalSueldos = 0.00;
                    var totalJubilaciones = 0.00;
                    var totalIndemnizaciones = 0.00;
                    $('.table-percepciones').find('tr').each(function(key, value) {
                        if (key >= 1) {
                            var concepto = $(this).find('td:eq(1)').find('input[name="percepciones-tipos[]"]').val();
                            if (concepto != "022" || concepto != "023" || concepto != "025" || concepto != "039" || concepto != "044") {
                                totalSueldos += parseFloat($(this).find('td:eq(2)').find('input[name="percepciones-gravados[]"]').val()) + parseFloat($(this).find('td:eq(3)').find('input[name="percepciones-excentos[]"]').val());
                            }
                            if (concepto == "039" || concepto == "044") {
                                totalJubilaciones += parseFloat($(this).find('td:eq(2)').find('input[name="percepciones-gravados[]"]').val()) + parseFloat($(this).find('td:eq(3)').find('input[name="percepciones-excentos[]"]').val());
                            }
                            if (concepto == "022" || concepto == "023" || concepto == "025") {
                                totalIndemnizaciones += parseFloat($(this).find('td:eq(2)').find('input[name="percepciones-gravados[]"]').val()) + parseFloat($(this).find('td:eq(3)').find('input[name="percepciones-excentos[]"]').val());
                            }
                        }
                    });
                    totalPercepciones = totalSueldos + totalJubilaciones + totalIndemnizaciones;

                    var totalDeducciones = 0.00;
                    $('.table-deducciones').find('tr').each(function(key, value) {
                        if (key >= 1) {
                            totalDeducciones += parseFloat($(this).find('td:eq(2)').find('input[name="deducciones-importes[]"]').val());
                        }
                    });

                    var totalOtrosPagos = 0.00;
                    $('.table-otros-pagos').find('tr').each(function(key, value) {
                        if (key >= 1) {
                            totalOtrosPagos += parseFloat($(this).find('td:eq(2)').find('input[name="otro-pago-importes[]"]').val());
                        }
                    });

                    $('.resumen-total-percepciones').find('strong').html(totalPercepciones);
                    $('.resumen-total-deducciones').find('strong').html(totalDeducciones);
                    $('.resumen-total-otros-pagos').find('strong').html(totalOtrosPagos);

                    var subTotal = totalPercepciones + totalOtrosPagos;
                    var total = subTotal - totalDeducciones;

                    $('.resumen-total').find('strong').html(total);
                break;
            }
        },
        afterSelect: function( event, state ) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
        }
    });

    $('.sncf_origen').change(function(event) {
        if ($('.sncf').is(":checked")) {
            if ($(this).val() === 'IM') {
                $('.sncf_monto').closest('.form-group').show();
            } else {
                $('.sncf_monto').closest('.form-group').hide();
            }
        } else {
            $('.sncf_origen').closest('.form-group').hide();
            $('.sncf_monto').closest('.form-group').hide();
        }
    });

    $('.sncf').click(function(event) {
        if ($(this).is(":checked")) {
            $('.sncf_origen').closest('.form-group').show();
            $('.sncf_monto').closest('.form-group').show();
        } else {
            $('.sncf_origen').closest('.form-group').hide();
            $('.sncf_monto').closest('.form-group').hide();
        }
        $('.sncf_origen').trigger('change');
    }).trigger('click');

    $('.btn-agregar-percepciones').click(function(event) {
        event.preventDefault();
        var ob = $(this).closest('.clone');
        var clave = ob.find('#clave').val();
        var concepto = ob.find('#concepto option:selected').html();
        var tipoPercepcion = ob.find('#concepto').val();
        var importeGravado = ob.find('#importe_gravado').val();
        var importeExcento = ob.find('#importe_excento').val();

        var inputClaves = '<input type="hidden" name="percepciones-claves[]" value="' + clave + '">';
        var inputConceptos = '<input type="hidden" name="percepciones-conceptos[]" value="' + concepto + '">';
        var inputTipos = '<input type="hidden" name="percepciones-tipos[]" value="' + tipoPercepcion + '">';
        var inputGravado = '<input type="hidden" name="percepciones-gravados[]" value="' + importeGravado + '">';
        var inputExcento = '<input type="hidden" name="percepciones-excentos[]" value="' + importeExcento + '">';

        var table = $('.table-percepciones');
        fila = "<tr>";
        fila += "<td>" + inputClaves + clave + "</td>";
        fila += "<td>" + inputConceptos + concepto + inputTipos + "</td>";
        fila += "<td>" + inputGravado + importeGravado + "</td>";
        fila += "<td>" + inputExcento + importeExcento + "</td>";
        fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-producto btn btn-danger"><i class="icmn-cross" aria-hidden="true"></i></a></td>';
        fila += "</tr>";
        table.find('tbody').append(fila);
        table.find('tr:last').find('.delete-producto').click(function(event) {
            var ob = $(this).closest('tr');
            ob.remove();
        });
    });

    $('.btn-agregar-deducciones').click(function(event) {
        event.preventDefault();
        var ob = $(this).closest('.clone');
        var clave = ob.find('#clave').val();
        var concepto = ob.find('#concepto option:selected').html();
        var tipoDeduccion = ob.find('#concepto').val();
        var importe = ob.find('#importe').val();

        var inputClaves = '<input type="hidden" name="deducciones-claves[]" value="' + clave + '">';
        var inputConceptos = '<input type="hidden" name="deducciones-conceptos[]" value="' + concepto + '">';
        var inputTipos = '<input type="hidden" name="deducciones-tipos[]" value="' + tipoDeduccion + '">';
        var inputGravado = '<input type="hidden" name="deducciones-importes[]" value="' + importe + '">';

        var table = $('.table-deducciones');
        fila = "<tr>";
        fila += "<td>" + inputClaves + clave + "</td>";
        fila += "<td>" + inputConceptos + concepto + inputTipos + "</td>";
        fila += "<td>" + inputGravado + importe + "</td>";
        fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-producto btn btn-danger"><i class="icmn-cross" aria-hidden="true"></i></a></td>';
        fila += "</tr>";
        table.find('tbody').append(fila);
        table.find('tr:last').find('.delete-producto').click(function(event) {
            var ob = $(this).closest('tr');
            ob.remove();
        });
    });

    $('.btn-agregar-otros-pagos').click(function(event) {
        event.preventDefault();
        var ob = $(this).closest('.clone');
        var clave = ob.find('#clave').val();
        var concepto = ob.find('#concepto option:selected').html();
        var tipoOtroPago = ob.find('#concepto').val();
        var importe = ob.find('#importe').val();
        var subcidioCausado = ob.find('#subsidio_causado').val();
        var saldoFavor = ob.find('#saldo_favor').val();
        var anio = ob.find('#anio').val();
        var remanente = ob.find('#remanente').val();

        var inputClaves = '<input type="hidden" name="otro-pago-claves[]" value="' + clave + '">';
        var inputConceptos = '<input type="hidden" name="otro-pago-conceptos[]" value="' + concepto + '">';
        var inputTipos = '<input type="hidden" name="otro-pago-tipos[]" value="' + tipoOtroPago + '">';
        var inputImporte = '<input type="hidden" name="otro-pago-importes[]" value="' + importe + '">';
        var inputSubcidios = '<input type="hidden" name="otro-pago-subcidios[]" value="' + subcidioCausado + '">';
        var inputSaldos = '<input type="hidden" name="otro-pago-saldos[]" value="' + saldoFavor + '">';
        var inputAnios = '<input type="hidden" name="otro-pago-anio[]" value="' + anio + '">';
        var inputRemanentes = '<input type="hidden" name="otro-pago-remanente[]" value="' + remanente + '">';

        var table = $('.table-otros-pagos');
        fila = "<tr>";
        fila += "<td>" + inputClaves + clave + "</td>";
        fila += "<td>" + inputConceptos + concepto + inputTipos + "</td>";
        fila += "<td>" + inputImporte + importe + "</td>";
        fila += "<td>" + inputSubcidios + subcidioCausado + "</td>";
        fila += "<td>" + inputSaldos + saldoFavor + "</td>";
        fila += "<td>" + inputAnios + anio + "</td>";
        fila += "<td>" + inputRemanentes + remanente + "</td>";
        fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-producto btn btn-danger"><i class="icmn-cross" aria-hidden="true"></i></a></td>';
        fila += "</tr>";
        table.find('tbody').append(fila);
        table.find('tr:last').find('.delete-producto').click(function(event) {
            var ob = $(this).closest('tr');
            ob.remove();
        });
    });

    $('#nuevo-empleado').click(function(event) {
        event.preventDefault();
        $('#form-agregar-empleado').find('input[name="tipo"]').val('insert');
        $('#form-agregar-empleado').find('input[name="id"]').val('');
        $('#modal-add-empleado').modal('show');
    });

    $('#actualizar-empleado').click(function(event) {
        event.preventDefault();
        // var data = "";
        $.each($('.recolect-empleado'), function(key, value) {
            var ob = $(value);
            $('#form-agregar-empleado').find('input[name="' + ob.attr('name') + '"]').val(ob.val());
            // data += ob.attr('name') + '=' + ob.val() + '&';
        });
        $('#form-agregar-empleado').find('input[name="tipo"]').val('update');
        var id = $('#empleado').val();
        $('#form-agregar-empleado').find('input[name="id"]').val(id);
        $('#modal-add-empleado').modal('show');
    });

    var validateAddEmpleado = $('#form-agregar-empleado').validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("Success.")
        },
        rules: {
            rfc: {
                required: true,
                maxlength: 15,
                regex: /^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]{3}$/,
            },
            curp: {
                required: true,
                maxlength: 200,
            },
            numSeguroSocial: {
                required: true,
                maxlength: 90,
            },
            numeroSeguridadSocial: {
                required: true,
                maxlength: 90,
            },
            calle: {
                required: true,
                maxlength: 90,
            },
            localidad: {
                required: true,
                maxlength: 30,
            },
            noExterior: {
                required: true,
                maxlength: 10,
            },
            noInterior: {
                maxlength: 10,
            },
            referencia: {
                required: true,
                maxlength: 90,
            },
            colonia: {
                required: true,
                maxlength: 50,
            },
            estado: {
                required: true,
                maxlength: 50,
            },
            pais: {
                required: true,
                maxlength: 50,
            },
            codigoPostal: {
                required: true,
                maxlength: 10,
            },
            telefono: {
                required: true,
                maxlength: 90,
            },
            email: {
                email: true,
            },
            registroPatronal: {
                required: true,
                maxlength: 90,
            },
            numeroEmpleado: {
                required: true,
                maxlength: 90,
            },
            puesto: {
                required: true,
                maxlength: 90,
            },
            fechaInicioLaboral: {
                required: true,
            },
            salario: {
                required: true,
            },
            salarioDiarioIntegrado: {
                required: true,
            },
            clabe: {
                required: true,
                maxLenght: 90,
            },
        },
        messages: {
            rfc: {
                required: 'Campo requerido',
                maxlength: 'Maximo 15 caracteres',
                regex: 'Valor de RFC no valido'
            },
            curp: {
                required: 'Campo requerido',
                maxlength: 'Maximo 30 caracteres',
            },
            numSeguroSocial: {
                required: 'Campo requerido',
                maxlength: 'Maximo 90 caracteres',
            },
            numeroSeguridadSocial: {
                required: 'Campo requerido',
                maxlength: 'Maximo 90 caracteres',
            },
            calle: {
                required: 'Campo requerido',
                maxlength: 'Maximo 90 caracteres',
            },
            localidad: {
                required: 'Campo requerido',
                maxlength: 'Maximo 30 caracteres',
            },
            noExterior: {
                required: 'Campo requerido',
                maxlength: 'Maximo 10 caracteres',
            },
            noInterior: {
                maxlength: 'Maximo 10 caracteres',
            },
            referencia: {
                required: 'Campo requerido',
                maxlength: 'Maximo 90 caracteres',
            },
            colonia: {
                required: 'Campo requerido',
                maxlength: 'Maximo 50 caracteres',
            },
            estado: {
                required: 'Campo requerido',
                maxlength: 'maximo 50 caracteres',
            },
            pais: {
                required: 'Campo requerido',
                maxlength: 'maximo 50 caracteres',
            },
            codigoPostal: {
                required: 'Campo requerido',
                maxlength: 'maximo 10 caracteres',
            },
            telefono: {
                required: 'Campo requerido',
                maxlength: 'maximo 90 caracteres',
            },
            email: {
                email: 'Email no valido',
            },
            registroPatronal: {
                required: 'Campo requerido',
                maxlength: 'maximo 90 caracteres',
            },
            numeroEmpleado: {
                required: 'Campo requerido',
                maxlength: 'maximo 90 caracteres',
            },
            puesto: {
                required: 'Campo requerido',
                maxlength: 'maximo 90 caracteres',
            },
            fechaInicioLaboral: {
                required: 'Campo requerido',
            },
            salario: {
                required: 'Campo requerido',
            },
            salarioDiarioIntegrado: {
                required: 'Campo requerido',
            },
            clabe: {
                required: 'Campo requerido',
                maxlength: 'maximo 90 caracteres',
            },
        },
        submitHandler: function(form) {
            form = $(form);
            $('div.mensaje-empleado').html('');
            switch (node.find('input[name="tipo"]').val()) {
                case 'update':
                    var id = node.find('input[name="id"]').val()
                    fnsGenerales.fnAJAX('/empleados/edit/' + id, 'POST', node.serialize(), 'JSON', null, function(response, success) {
                        if (success && response.success) {
                            fnsGenerales.loadSelectEmpleados('.mensaje-empleado-editar');
                            validateAddEmpleado.reset();
                        }
                    });
                break;
                case 'insert':
                    fnsGenerales.fnAJAX('/empleados/add', 'POST', node.serialize(), 'JSON', null, function(response, success) {
                        if (success && response.success) {
                            fnsGenerales.loadSelectEmpleados('.mensaje-empleado-agregar');
                            validateAddEmpleado.reset();
                        }
                    });
                break;
            }
            return false;
        }
    });

    $('#empleados').change(function(event) {
        $('div.mensaje-empleado').html('');
        if ($('#empleados').val() !== null) {
            fnsGenerales.fnAJAX('/empleados/info/' + $('#empleados').val(), 'GET', {}, 'JSON', null, function(response, success) {
                if (success && response.success) {
                    $.each(response.data, function(key, value) {
                        if ($.type(value) === 'object' && key === "fechaInicioLaboral") {
                            value = value.date.substr(0,10);
                        }
                        $('.empleado-' + key).val(value);
                    });
                }
            });
        }
    }).trigger('change');
});
