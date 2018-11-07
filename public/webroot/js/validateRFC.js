//Función para validar un RFC
// Devuelve el RFC sin espacios ni guiones si es correcto
// Devuelve false si es inválido
// (debe estar en mayúsculas, guiones y espacios intermedios opcionales)
function rfcValido(rfc, aceptarGenerico = true) {
    const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var   validado = rfc.match(re);

    if (!validado)  //Coincide con el formato general del regex?
        return false;
/*
    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
          rfcSinDigito      = validado.slice(1).join(''),
          len               = rfcSinDigito.length,
/*
    //Obtener el digito esperado
          diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
          indice            = len + 1;
    var   suma,
          digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for(var i=0; i<len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dígito verificador coincide con el esperado?
    // o es un RFC Genérico (ventas a público general)?
    if ((digitoVerificador != digitoEsperado)
     && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;*/
    return true;
}


//Handler para el evento cuando cambia el input
// -Lleva la RFC a mayúsculas para validarlo
// -Elimina los espacios que pueda tener antes o después
function validarInput(input) {
    var rfc         = input.value.trim().toUpperCase(),
        resultado   = document.getElementById("resultado"),
        valido;
        
    var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
  
    if (rfcCorrecto) {
    	valido = "Válido";
      resultado.classList.add("ok");
    } else {
    	valido = "No válido"
    	resultado.classList.remove("ok");
    }
        
    resultado.innerText = "RFC: " + rfc 
                        + "\nResultado: " + rfcCorrecto
                        + "\nFormato: " + valido;
}

function validacion(){
    var rfc = $('#RFC').val().toUpperCase(),
        email = $('#email').val(),
        password = $('#password').val(),
        confirmation = $('#confirmation').val(),
        admin = $('#admin').val();

    if(rfc == null || rfc.length == 0 || /^\s+$/.test(rfc)){
         alert('El campo RFC debe estar lleno');
        return false;
    }
    else if(rfcValido(rfc) == false){
        alert('RFC no válido');
        return false;
    }
    else if(email == null || email.length == 0 || /^\s+$/.test(email)){
        alert('El campo email debe estar lleno');
        return false;
    }
    else if(!(/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/.test(email))){
        alert('Email no váido');
        return false;
    }
   else  if(password == null || password.length == 0 || /^\s+$/.test(password)){
        alert('El campo contraseña debe estar lleno');
        return false;
    }
    else if(confirmation == null || confirmation.length == 0 || /^\s+$/.test(confirmation)){
        alert('El campo confirmar contraseña debe estar lleno');
        return false;
    }
    else if (password !== confirmation) {
        alert('Las contraseñas no son iguales');
        return false;
    }
    else if(admin == null || admin.length == 0 || /^\s+$/.test(admin)){
        alert('El campo admin debe estar lleno');
        return false;
    }
    else
    return true;
}