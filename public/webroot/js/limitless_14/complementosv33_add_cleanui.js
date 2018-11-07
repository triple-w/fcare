$(function(){

    $('.cfdi-nuevo').hide();
    $('#nParcialidad').prop('readonly', true);
    $('.radio input').change(function(){
        $('.clone').show();
        if(this.value == '1'){
            $('.cfdi-nuevo').show();
            $('.cfdi-existente').hide();
            $('.clone input.llenar').prop('readonly', false);
            $('.clone #fMoneda, .clone #fMetodoPago').prop('disabled', false);
            $('.clone #select-tipo-monedaDR, .clone #select-tipo-monedaDR').prop('disabled', false);
            $('.clone #select-tipo-monedaDR, .clone #select-tipo-monedaDR').prop('disabled', false);
        } else {
            $('.cfdi-nuevo').hide();
            $('.cfdi-existente').show();
            $('.clone input.llenar').prop('readonly', true);
            $('.clone #fMoneda, .clone #fMetodoPago').prop('disabled', true);
             $('.clone #select-tipo-monedaDR, .clone #select-tipo-monedaDR').prop('disabled', true);
            $('.clone #tipomonedaDR, .clone #tipomonedaDR').prop('disabled', true);
            cargarCfdisCliente();
        }
        $('.clone input.llenar').val('');
    });

    $('#fMetodoPago').change(function(){
        if(this.value == 'PPD'){
            $('#fParcialidad').prop('readonly', false);
        } else {
            $('#fParcialidad').prop('readonly', true);
        }
    });

    $('#formaPago').change(function(){
        if(this.value == '01'){
            $('.opcionales input').prop('readonly', true);
        } else {
            $('.opcionales input').prop('readonly', false);
        }
    });

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

    $('#tipoMoneda').change(function(event) {
        if ($(this).val() == 'MXN' && $('#fMoneda').val() == 'MXN') {
            $('.cont-tipo-moneda').hide();
        } else {
            $('.cont-tipo-moneda').show();
        }
    });

    $('#fMoneda').change(function(event) {
        if ($(this).val() == 'MXN' && $('#tipoMoneda').val() == 'MXN') {
            $('.cont-tipo-moneda').hide();
        } else {
            $('.cont-tipo-moneda').show();
        }
    });

    $('#actualizar-cliente').click(function(event) {
        event.preventDefault();
        $.each($('.recolect-cliente'), function(key, value) {
            var ob = $(value);
            $('#form-agregar-cliente').find('input[name="' + ob.attr('name') + '"]').val(ob.val());
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

    function cargarCfdisCliente() {
        //AJAX para cargar cfdis del cliente seleccionado
        var crfc = $('.cliente-rfc').val();
        $.ajax({
            type: 'GET',
            url: 'cfdi-by-cliente',
            dataType : 'html',
            data: {'rfc': crfc},
            beforeSend: function (jqXHR, settings) {
                return jqXHR.setRequestHeader('X-CSRF-TOKEN', $('#csrf-token').attr('value'));
            },
            success: function(data){
                $('.cfdi-existente').html(data);
                initSelect2Cfdis();
            },
            error: function(data){
                $('.cfdi-existente').html('<p color="red">Error al intentar cargar los cfdis</p>');
            }
        });
    }

    function initSelect2Cfdis(){
        $('#cfdis').select2();
        $('#cfdis').change(function(event) {
            if ($('#cfdis').val() !== null) {
                id = $('#cfdis').val();
                $.ajax({
                    type: 'GET',
                    url: 'info-cfdi',
                    dataType : 'html',
                    data: {'id': id},
                    beforeSend: function (jqXHR, settings) {
                        return jqXHR.setRequestHeader('X-CSRF-TOKEN', $('#csrf-token').attr('value'));
                    },
                    success: function(data){
                        json = JSON.parse(data);
                        console.log(json);
                        $.each(json, function(key, value){
                            $('.cfdi-'+key).val(value);
                        });
                        $('.clone #fMetodoPago').val(json['metodoPago']).trigger('change');
                        $('.clone #fMoneda').val(json['moneda']).trigger('change');
                        $('.clone #select-tipo-monedaDR').val(json['moneda']).trigger('change');
                        $('#fMetodoPago').prop("disabled", true);
                        $('#fMoneda').prop("disabled", true);

                        $('#tipomonedaDR').prop("disabled", true);
                        if(json['moneda'] !== $('#fMoneda').val()){
                            $('.cont-tipo-moneda').show();

                        }else{
                            $('.cont-tipo-moneda').hide();

                        }
                    },
                    error: function(data){
                        console.log('error recibiendo info de los cfdis');
                    }
                });
            }
        }).trigger('change');
    }

    //progress bar
    $("#progressbar").progressbar();

    $('#form-wizard').wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeSelect: function( event, state ) {
            switch (state.stepIndex) {
                case 1:
                    if ($('.cliente-rfc').val() === '') {
                        $('div.mensaje-cliente').html('Porfavor agrega al menos un cliente');
                        return false;
                    }
                    cargarCfdisCliente();
                break;
                case 2:
                    if ($('div.cont > div.table-responsive > table.table-cfdis > tbody > tr').length <= 0) {
                        $('div.mensaje').html('Porfavor agrega al menos un cfdi');
                        return false;
                    }
                    if ($('.forma-pago').val() == "") {
                        $('div.mensaje-pago').html('Porfavor llena este campo');
                        return false;
                    }

                    $('.clone-cfdis').html('');

                    var table = $('.table-cfdis').clone();
                    table.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
                    table.find('tbody > tr > td > input').remove();
                    $('.clone-cfdis').html(table);

                    $('.Cforma-pago > span').html($('.forma-pago').val());
                    $('.Ctipo-moneda > span').html($('#select-tipo-moneda').val());
                    $('.Ctipo-cambio > span').html($('#select-tipo-moneda').val() === 'MXN' ? 1 : $('.tipo-moneda').val());

                    var folio = '';
                    var fecha = '';
                    var monto = 0;
                    var saldo = 0;
                    var pago = 0;
                    var tmonto= 0;
                    var tpago = 0;
                    var tsaldo = 0;
                    $.each($('div.clone-cfdis > table.table-cfdis > tbody > tr'), function(key, value) {
                        folio = $(value).find('td:eq(0)').html();
                        fecha = $(value).find('td:eq(1)').html();
                        monto = parseFloat($(value).find('td:eq(2)').html());
                        pago =  parseFloat($(value).find('td:eq(3)').html());
                        saldo = parseFloat($(value).find('td:eq(4)').html());
                        tmonto += monto;
                        tpago += pago;
                    });
                    tsaldo = tmonto - tpago;
                    var nuevoSaldo = monto - pago;
                    $('.Csubtotal > span').html(round(tmonto,2));
                    $('.Cpago > span').html(round(tpago,2));
                    $('.Cnuevo-subtotal > span').html(round(tsaldo,2));

                    $('.subtotal > span').html(round(tsaldo,2));

                    $('.Ctotal > span').html(round(tpago,2));

                    $('.Ccomprobante').html($('#nombreComprobante option:selected').html());
                    $('.Cfecha-comprobante').html($('#fechaPago').val());
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

    var subtotal = 0;
    var contadorGlobal = 0;
    $('.btn-agregar').click(function(event) {
        event.preventDefault();
        var ob = $(this).closest('.clone');
        var table = $('.table-cfdis');
        var idCfdi = $('#cfdis').val();
        var valorFolio = ob.find('.cfdi-serie').val()+'-'+ob.find('.cfdi-folio').val();
        var valorMonedaCfdi = ob.find('#fMoneda').val();
        var valorMetodoCfdi = ob.find('#fMetodoPago').val();
        var valorParcialidad = ob.find('#fParcialidad').val();
        var valorUuid = ob.find('.cfdi-uuid').val();
        var valorFechaPago = ob.find('.fechaPago').val();
        var valorPago = parseFloat(ob.find('.monto-pago').val());
        valorPago = round(valorPago,2);
        var valorMonto = ob.find('.cfdi-saldoInsoluto').val();
        var valorMonedaPago = ob.find('#tipoMoneda').val();
        var valorTipoCambioP = ob.find('#tipoCambio').val();
        var valorMonto = ob.find('.cfdi-saldoInsoluto').val();
        var valorSaldo = round(valorMonto - valorPago,2);

        var formaPago = ob.find('#formaPago').val();

        var valorPagoIngresado = "";

        valorSaldo = round(valorMonto - valorPago,2);
        valorPagoIngresado = valorPago;

        var numOp = ob.find('.numOp').val();
        var bcoEmisor = ob.find('.bcoEmisor').val();
        var bcoReceptor = ob.find('.bcoReceptor').val();
        var ctaOrd = ob.find('.ctaOrd').val();
        var ctaBen = ob.find('.ctaBen').val();

        if($('.radio input').val() == '1'){
            idCfdi = uuid;
        }
        var inputIdCfdi = '<input type="hidden" name="id-cfdi[' + contadorGlobal + ']" value="' + idCfdi + '">';
        var inputUuid = '<input type="hidden" name="iUuid[' + contadorGlobal + ']" value="' + valorUuid + '">';
        var inputFecha = '<input type="hidden" name="ifechaPago[' + contadorGlobal + ']" value="' + valorFechaPago + '">';
        var inputFolio = '<input type="hidden" name="ifolios[' + contadorGlobal + ']" value="' + valorFolio + '">';
        var inputMonedaCfdi = '<input type="hidden" name="moneda-cfdi[' + contadorGlobal + ']" value="' + valorMonedaCfdi + '">';
        var inputMonedaPago = '<input type="hidden" name="moneda-pago[' + contadorGlobal + ']" value="' + valorMonedaPago + '">';
        var inputTipoCambio = '<input type="hidden" name="tipo-cambio[' + contadorGlobal + ']" value="' + valorTipoCambioP + '">';
        var inputMetodoCfdi = '<input type="hidden" name="metodo-cfdi[' + contadorGlobal + ']" value="' + valorMetodoCfdi + '">';
        var inputParcialidad = '<input type="hidden" name="noParcialidad[' + contadorGlobal + ']" value="' + valorParcialidad + '">';
        var inputMonto = '<input type="hidden" name="imontos[' + contadorGlobal + ']" value="' + valorMonto + '">';
        var inputPagoIngresado = '<input type="hidden" name="ipagosIngresado[' + contadorGlobal + ']" value="' + valorPagoIngresado + '">';
        var inputPago = '<input type="hidden" name="ipagos[' + contadorGlobal + ']" value="' + valorPago + '">';
        var inputSaldo = '<input type="hidden" name="isaldos[' + contadorGlobal + ']" value="' + valorSaldo + '">';

        var inputNumOp = '<input type="hidden" name="inumOp['+contadorGlobal+']" value="'+numOp+'">';
        var inputBcoEmisor = '<input type="hidden" name="ibcoEmisor['+contadorGlobal+']" value="'+bcoEmisor+'">';
        var inputBcoReceptor = '<input type="hidden" name="ibcoReceptor['+contadorGlobal+']" value="'+bcoReceptor+'">';
        var inputCtaOrd = '<input type="hidden" name="ictaOrd['+contadorGlobal+']" value="'+ctaOrd+'">';
        var inputCtaBen = '<input type="hidden" name="ictaBen['+contadorGlobal+']" value="'+ctaBen+'">';

        $("div[class^='mensaje-']").html('');

        var valid = true;
        if(valorUuid == ''){
            $('div.mensaje-uuid').html('El UUID de la factura es obligatorio');
            valid = false;
        }
        if(valorMonto == '' | valorMonto == 0 ){
            $('div.mensaje-saldo').html('El saldo por pagar de la factura es obligatorio');
            valid = false;
        }
        if (!$.isNumeric(valorPago)) {
            $('div.mensaje-monto').html('El pago debe ser numérico');
            valid = false;
        } else {
            if (valorPago <= 0) {
                $('div.mensaje-monto').html('El pago debe ser mayor a 0');
                valid = false;
            } else {
                if (valorPago > valorMonto) {
                    $('div.mensaje-monto').html('El pago debe ser menor o igual al monto');
                    valid = false;
                }
            }
        }

        if (numOp !== '' || bcoEmisor !== '' || bcoReceptor !== '' || ctaOrd !== '' || ctaBen !== ''){
            if (numOp == ''){
                $('div.mensaje-opciones').html('Llenar todos los campos opcionales');
                valid = false;
            }else if(bcoEmisor == ''){
                $('div.mensaje-opciones').html('Llenar todos los campos opcionales');
                valid = false;
            }else if (bcoReceptor == '') {
                $('div.mensaje-opciones').html('Llenar todos los campos opcionales');
                valid = false;
            }else if(ctaOrd == ''){
                $('div.mensaje-opciones').html('Llenar todos los campos opcionales');
                valid = false;
            }else if(ctaBen == ''){
                $('div.mensaje-opciones').html('Llenar todos los campos opcionales');
                valid = false;
            }
        }

        if (!valid) {
            return false;
        }
        
        contadorGlobal++;

        var fila = '<tr>';
        fila += '<td>' + inputUuid + inputFolio + valorFolio + inputMonedaCfdi + inputMetodoCfdi +'</td>';
        fila += '<td>' + inputFecha + valorFechaPago + '</td>';
        fila += '<td>' + inputMonto + valorMonto + inputMonedaPago + inputTipoCambio +'</td>';
        fila += '<td>' + inputPago + inputPagoIngresado + valorPago + '</td>';
        fila += '<td>' + inputIdCfdi + inputSaldo + valorSaldo + inputNumOp + inputBcoEmisor + inputBcoReceptor + inputCtaOrd + inputCtaBen +'</td>';
        fila += '<td class="delete"><a href="#" data-toggle="tooltip", data-placement="bottom" data-original-title="Editar" class="delete-producto btn btn-danger"><i class="icmn-cross" aria-hidden="true"></i></a></td>';
        fila += '</tr>';

        table.find('tbody').append(fila);
        $('div.mensaje').html('');

        $('.subtotal > span').html(round(subtotal, 2));

        if (subtotal > 0) {
            $('.subtotal').show();
        }

        table.find('tr:last').find('.delete-producto').click(function(event) {
            event.preventDefault();
            var ob = $(this).closest('tr');

            $('.subtotal > span').html(round(subtotal, 2));

            if (subtotal <= 0) {
                $('.subtotal').hide();
            }
            ob.remove();
        });

    });

})


/*
 * Al trabajar con decimales JavaScript redondea el .5 hacia abajo
 * ej. 1.005 => 1.00
 * la siguiente función hace que redondear decimales a partir del 5 sea hacia arriba
 * ej. 1.005 => 1.01
 */

function round(valor, decimales) {
  return Number(Math.round(valor+'e'+decimales)+'e-'+decimales);
}
