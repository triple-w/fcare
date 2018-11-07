<?php $__env->startSection('title', 'Timbres'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('elements.form_pago_mp', [ 'attrsForm' => [ 'id' => 'pay', 'name'=>'pay'], 'tipo' => 'TIMBRES' ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <script>
    Mercadopago.setPublishableKey("TEST-52f3f0d9-51ca-4592-a2cd-1202f7fba3c6");
    
    
    function addEvent(el, eventName, handler){
    if (el.addEventListener) {
           el.addEventListener(eventName, handler);
    } else {
        el.attachEvent('on' + eventName, function(){
          handler.call(el);
        });
    }
    };

    function guessingPaymentMethod(event) {
    var bin = getBin();

    if (event.type == "keyup") {
        if (bin.length >= 6) {
            Mercadopago.getPaymentMethod({
                "bin": bin
            }, setPaymentMethodInfo);
        }
    } else {
        setTimeout(function() {
            if (bin.length >= 6) {
                Mercadopago.getPaymentMethod({
                    "bin": bin
                }, setPaymentMethodInfo);
            }
        }, 100);
    }
    };
    
    function setPaymentMethodInfo(status, response) {
    if (status == 200) {
        paymentMethod.setAttribute('name', "paymentMethodId");
        paymentMethod.setAttribute('type', "hidden");
        paymentMethod.setAttribute('value', response[0].id);

        form.appendChild(paymentMethod);
        alert(response[0].id);
        } else {
            document.querySelector("input[name=paymentMethodId]").value = response[0].id;
        }
    };
    
    doSubmit = false;
    addEvent(document.querySelector('#pay'), 'submit', doPay);
    function doPay(event){
    event.preventDefault();
    if(!doSubmit){
        var $form = document.querySelector('#pay');

        Mercadopago.createToken($form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below

        return false;
    }

   
    };

    function sdkResponseHandler(status, response) {
        if (status != 200 && status != 201) {
            if(status == 205){
                alert("Ingresa el número de tu tarjeta.");
            }
            else if(status == 208){
                alert("Elige un mes.");
            }
            else if(status == 209){
                alert("Elige un año.");
            }
            else if(status == 221){
                alert("Ingresa el nombre y apellido.");
            }
            else if(status == 224){
                alert("Ingresa el código de seguridad.");
            }
            else if(status == 'E301'){
                alert("Hay algo mal en ese número. Vuelve a ingresarlo..");
            }
            else if(status == 'E302'){
                alert("Revisa el código de seguridad.");
            }
            else if(status == 325){
                alert("Revisa la fecha.");
            }
            else if(status == 326){
                alert("Revisa la fecha.");
            }           
            else{
                alert("Revisa los datos.");
            }
        }
        else{
        
            var form = document.querySelector('#pay');

            var card = document.createElement('input');
            card.setAttribute('name',"token");
            card.setAttribute('type',"hidden");
            card.setAttribute('value',response.id);
            form.appendChild(card);
            doSubmit=true;
            form.submit();
        }
    };

    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0'); ?>

    <!--<?php echo HTML::scriptLocal('webroot/js/limitless_14/pago_timbres.js?v=1.4.0'); ?>-->
<?php $__env->appendSection(); ?>
