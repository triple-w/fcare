var fnsGenerales = {
    fnAJAX: function (url, type, data, dataType, contentType, callBack, beforeSend, complete) {
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
                if ($.type(beforeSend) === "function") {
                    beforeSend();
                }
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
                if ($.type(complete) === "function") {
                    complete();
                }
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
    },
    select2AJAX : function (ob, url, id, text) {
        $(ob).select2({
            ajax: {
                url: $('#url-public').attr('value') + url,
                type: 'GET',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term
                    }
                },
                processResults: function(data, params) {
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: item.descripcion,
                                id: item.id,
                            }
                        })
                    }
                },
                beforeSend: function (jqXHR, settings) {
                    return jqXHR.setRequestHeader('X-CSRF-TOKEN', $('#csrf-token').attr('value'));
                },
            },
            minimumInputLength: 3,
            initSelection: function(element, callback) {
                if (id != null) {
                    $(ob).append('<option value="' + id + '">' + text + '</option>');
                    return callback({ 'id': id, 'text': text });
                } else {
                    fnsGenerales.fnAJAX(url, 'GET', 'limit=1', 'JSON', null, function(response, success) {
                    $(ob).append('<option value="' + response.data[0].id + '">' + response.data[0].descripcion + '</option>');
                        return callback({ 'id': response.data[0].id, 'text': response.data[0].descripcion });
                    });
                }
            },
        });
    }
};

