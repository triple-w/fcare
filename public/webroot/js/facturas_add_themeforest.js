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
					// 	$('.mensaje-cliente-agregar').hide();
					// 	$('.mensaje-cliente-editar').hide();
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

	$('#form-agregar-cliente').bootstrapValidator({
        fields: {
            rfc: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 15,
                        message: 'Maximo 15 caracteres'
                    },
                    regexp: {
                        regexp: /^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]{3}$/,
                        message: 'RFC no valido'
                    },
                }
            },
            razonSocial: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 90,
                        message: 'Maximo 90 caracteres'
                    },
                }
            },
            calle: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 90,
                        message: 'Maximo 90 caracteres'
                    },
                }
            },
            noExt: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 10,
                        message: 'Maximo 10 caracteres'
                    },
                }
            },
            noInt: {
                validators: {
                    stringLength: {
                        max: 10,
                        message: 'Maximo 10 caracteres'
                    },
                }
            },
            colonia: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 30,
                        message: 'Maximo 30 caracteres'
                    },
                }
            },
            municipio: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 30,
                        message: 'Maximo 30 caracteres'
                    },
                }
            },
            localidad: {
                validators: {
                    stringLength: {
                        max: 30,
                        message: 'Maximo 30 caracteres'
                    },
                }
            },
            estado: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 30,
                        message: 'Maximo 30 caracteres'
                    },
                }
            },
            codigoPostal: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 10,
                        message: 'Maximo 10 caracteres'
                    },
                }
            },
            pais: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        max: 30,
                        message: 'Maximo 30 caracteres'
                    },
                }
            },
            telefono: {
                validators: {
                    stringLength: {
                        max: 30,
                        message: 'Maximo 30 caracteres'
                    },
                }
            },
            nombreContacto: {
                validators: {
                    stringLength: {
                        max: 90,
                        message: 'Maximo 90 caracteres'
                    },
                }
            },
            email: {
                validators: {
                    emailAddress: {
                        message: 'Ingresa una direccion de correo valida'
                    }
                }
            },
        },
        submitHandler: function(validator, form) {
        	switch (form.find('input[name="tipo"]').val()) {
        		case 'update':
        			var id = form.find('input[name="id"]').val()
	        		fnsGenerales.fnAJAX('/clientes/edit/' + id, 'POST', form.serialize(), 'JSON', null, function(response, success) {
			    		if (success && response.success) {
			    			fnsGenerales.loadSelectClientes('.mensaje-cliente-editar');
			    		}
			    	});
        		break;
        		case 'insert':
        			fnsGenerales.fnAJAX('/clientes/add', 'POST', form.serialize(), 'JSON', null, function(response, success) {
		        		if (success && response.success) {
		        			fnsGenerales.loadSelectClientes('.mensaje-cliente-agregar');
		        		}
		        	});
        		break;
        	}
        	return false;
        }
    });

	$('#clientes').change(function(event) {
 		fnsGenerales.fnAJAX('/clientes/info/' + $('#clientes').val(), 'GET', {}, 'JSON', null, function(response, success) {
 			$('#error').html(response);
			if (success && response.success) {
				$.each(response.data, function(key, value) {
					$('.cliente-' + key).val(value);
				});
			}
		});
	}).trigger('change');

	//  progress bar
	// $("#progressbar").progressbar();

	// $('#form-wizard').wizard({
	// 	stepsWrapper: "#wrapped",
	// 	submit: ".submit",
	// 	beforeSelect: function( event, state ) {
	// 		switch (state.stepIndex) {
	// 			case 2:
	// 				if ($('div.cont > table.table-productos > tbody > tr').length <= 0) {
	// 					$('div.mensaje').html('Porfavor agrega al menos un producto');
	// 					return false;
	// 				}
	// 			break;
	// 			case 3:
	// 				// fnsGenerales.fnAJAX('/clientes/info/' + $('#clientes option:selected').val(), 'GET', {}, 'JSON', null, function(response, success) {
	// 				// 	if (success && response.success) {

	// 				// 	}
	// 				// });
	// 				if ($('.forma-pago').val() == "") {
	// 					$('div.mensaje-pago').html('Porfavor llena este campo');
	// 					return false;
	// 				}

	// 				$('.clone-productos').html('');

	// 				var table = $('.table-productos').clone();
	// 				table.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
	// 				table.find('tbody > tr > td > input').remove();
	// 				$('.clone-productos').html(table);

	// 				$('.Civa-trasladado > span').html($('.iva-trasladado').val());
	// 				$('.Cvalor-iva > span').html($('.valor-iva').val());
	// 				$('.Cieps-trasladado > span').html($('.ieps-trasladado').val());
	// 				$('.Civa-retenido > span').html($('.iva-retenido').val());
	// 				$('.Cisr-retenido > span').html($('.isr-retenido').val());

	// 				$('.Cforma-pago > span').html($('.forma-pago').val());
	// 				$('.Ctipo-moneda > span').html($('#select-tipo-moneda').val());
	// 				$('.Ctipo-cambio > span').html($('#select-tipo-moneda').val() === 'MXN' ? 1 : $('.tipo-moneda').val());
	// 				$('.Cmetodo-pago > span').html($('.metodo-pago').val());
	// 				$('.Cnumero-cuenta > span').html($('.numero-cuenta').val());

	// 				$('.Csubtotal > span').html($('.subtotal > span').html());
	// 				$('.Cmotivo-descuento > span').html($('.motivo-descuento').val());
	// 				var descuento = 0;
	// 				var subtotal = parseFloat($('.subtotal > span').html());
	// 				if ($('.descuento').val() != "") {
	// 					descuento = parseFloat($('.descuento').val());
	// 					descuento = subtotal * (descuento / 100);
	// 				};
	// 				$('.Cdescuento > span').html(descuento);
	// 				var nuevoSubTotal = subtotal - descuento;
	// 				$('.Cnuevo-subtotal > span').html(nuevoSubTotal);

	// 				var importe = 0;
	// 				$.each($('div.clone-productos > table.table-productos > tbody > tr'), function(key, value) {
	// 					importe += parseFloat($(value).find('td:eq(4)').html());
	// 				});
	// 				var ivaTrasladado = parseFloat($('.valor-iva').val());
	// 				var iepsTrasladado = $('.ieps-trasladado-valor').val() !== "" ? parseFloat($('.ieps-trasladado-valor').val()) : 0 ;
	// 				var ivaRetenido = 0;
	// 				var isrRetenido = 0;
	// 				var valIvaRetenido = $('.iva-retenido').val() !== "" ? parseFloat($('.iva-retenido').val()) : 0;
	// 				if (valIvaRetenido > 0) {
	// 					ivaRetenido = (valIvaRetenido / 100) * $('.subtotal > span').html();
	// 				}
	// 				var valIsrRetenido = $('.isr-retenido').val() !== "" ? parseFloat($('.isr-retenido').val()) : 0;
	// 				if (valIsrRetenido) {
	// 					isrRetenido = (valIsrRetenido / 100) * $('.subtotal > span').html();
	// 				}

	// 				console.log(importe, ivaTrasladado, iepsTrasladado, ivaRetenido, isrRetenido, descuento);
	// 				var total = (importe + ivaTrasladado + iepsTrasladado + ivaRetenido + isrRetenido) - descuento;

	// 				$('.Ctotal > span').html(total.toFixed(2));
	// 			break;
	// 		}
	// 	},
	// 	afterSelect: function( event, state ) {
	// 		$("#progressbar").progressbar("value", state.percentComplete);
	// 		$("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
	// 	}	
	// });


	$('#form-wizard').easyWizard({
		buttonsClass: 'btn btn-default',
		submitButtonClass: 'btn btn-primary',
		submitButtonText: 'Generar Factura',
		before: function(wizardObj, currentStepObj, nextStepObj) {
			switch (nextStepObj.selector) {
				case '.step[data-step="3"]':
					if ($('div.cont > table.table-productos > tbody > tr').length <= 0) {
						$('div.mensaje').html('Porfavor agrega al menos un producto');
						return false;
					}
				break;
				case '.step[data-step="4"]':
					// fnsGenerales.fnAJAX('/clientes/info/' + $('#clientes option:selected').val(), 'GET', {}, 'JSON', null, function(response, success) {
					// 	if (success && response.success) {

					// 	}
					// });
					if ($('.forma-pago').val() == "") {
						$('div.mensaje-pago').html('Porfavor llena este campo');
						return false;
					}

					$('.clone-productos').html('');

					var table = $('.table-productos').clone();
					table.find('thead > tr > th.delete, tbody > tr > td.delete').remove();
					table.find('tbody > tr > td > input').remove();
					$('.clone-productos').html(table);

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
					if ($('.descuento').val() != "") {
						descuento = parseFloat($('.descuento').val());
						descuento = subtotal * (descuento / 100);
					};
					$('.Cdescuento > span').html(descuento);
					var nuevoSubTotal = subtotal - descuento;
					$('.Cnuevo-subtotal > span').html(nuevoSubTotal);

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
						ivaRetenido = (valIvaRetenido / 100) * $('.subtotal > span').html();
					}
					var valIsrRetenido = $('.isr-retenido').val() !== "" ? parseFloat($('.isr-retenido').val()) : 0;
					if (valIsrRetenido) {
						isrRetenido = (valIsrRetenido / 100) * $('.subtotal > span').html();
					}

					var total = (importe + ivaTrasladado + iepsTrasladado + ivaRetenido + isrRetenido) - descuento;

					$('.Ctotal > span').html(total.toFixed(2));
				break;
			}
		},
		// after: function(wizardObj, prevStepObj, currentStepObj) {
		// 	console.log("entreafter");
		// },
		// 'stepClassName' : 'step',
		// 'showSteps' : true,
		// 'stepsText' : '{n} {t}',
		// 'showButtons' : true,
		// 'buttonsClass' : '',
		// 'prevButton' : '&laquo; Back',
		// 'nextButton' : 'Next &raquo;',
		// 'debug' : false,
		// 'submitButton': true,
		// 'submitButtonText': 'Submit',
		// 'submitButtonClass': '',
		// before: function(wizardObj, currentStepObj, nextStepObj) {},
		// after: function(wizardObj, prevStepObj, currentStepObj) {},
		// beforeSubmit: function(wizardObj) {
		// 	wizardObj.find('input, textarea').each(function() {
		// 		if(!this.checkValidity()) {
		// 			this.focus();
		// 			step = $(this).parents('.'+thisSettings.stepClassName).attr('data-step');
		// 			easyWizardMethods.goToStep.call(wizardObj, step);
		// 			// $.fn.easyWizard('goToStep');
		// 			return false;
		// 		}
		// 	});
		// }
	});

	$('.forma-pago').keyup(function(event) {
		$('div.mensaje-pago').html('');
	});

	$('select').select2();

	$('#productos').change(function(event) {
		fnsGenerales.fnAJAX('/productos/info/' + $(this).val(), 'GET', {}, 'JSON', null, function(response, success) {
			if (success && response.success) {
				$('#precio').val(response.data.precio);
			}
		});
	}).trigger('change');

	var subtotal = 0;
	$('.btn-agregar').click(function(event) {
		event.preventDefault();
		var ob = $(this).closest('.clone');
		var table = $('.table-productos');

		var inputProductos = '<input type="hidden" name="productos[]" value="' + ob.find('#productos').val() + '">';
		var inputPrecio = '<input type="hidden" name="precios[]" value="' + ob.find('#precio').val() + '">';
		var inputCantidad = '<input type="hidden" name="cantidad[]" value="' + ob.find('#cantidad').val() + '">';
		var inputTipoImpuesto = '<input type="hidden" name="productos-tipo-impuesto[]" value="' + ob.find('#tipo-impuesto').val() + '">';

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

		var fila = '<tr>';
		fila += '<td>' + inputProductos + ob.find('#productos > option:selected').html() + '</td>';
		fila += '<td>' + inputCantidad + ob.find('#cantidad').val() + '</td>';
		fila += '<td>' + inputPrecio + ob.find('#precio').val() + '</td>';
		fila += '<td>' + inputTipoImpuesto + ob.find('#tipo-impuesto').val() + '</td>';
		// fila += '<td>' + iva.toFixed(2) + '</td>';
		fila += '<td>' + importe.toFixed(2) + '</td>';
		fila += '<td class="delete"><a href="#" class="delete-producto btn btn-danger">Eliminar</a></td>';
		fila += '</tr>';

		table.find('tbody').append(fila);
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
			var iva = ob.find('.productos-tipo-impuesto').val() == 1 ? (ob.find('.precios').val() - precio) * ob.find('.cantidad').val() : (ob.find('.precio').val() * .16) * ob.find('.cantidad').val()

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
		if ($(this).val() != "") {
			descuento = parseFloat($(this).val());
			descuento = subtotal * (descuento / 100);
		};
		var nuevoSubtotal = subtotal - descuento;
		var valorIva = nuevoSubtotal * ($('.iva-trasladado').val() / 100);
		$('.valor-iva').val(valorIva.toFixed(2));
	});

	$('.iva-trasladado').keyup(function(event) {
		var subtotal = parseFloat($('.subtotal > span').html());
		if ($(this).val() != "") {
			descuento = parseFloat($('.descuento').val());
			descuento = subtotal * (descuento / 100);
		};
		var nuevoSubtotal = subtotal - descuento;

		var valorIva = nuevoSubtotal * ($('.iva-trasladado').val() / 100);
		$('.valor-iva').val(valorIva.toFixed(2));
	});

})