<style>
    input#mesesAnteriores {
        display: none;
    }
</style>
<h2>Tarjeta de crédito o débito</h2>
<div class="row">
    <div class="col-md-2">
        <?php echo HTML::image('webroot/img/cards1.png', 'Cards', [ 'class' => 'img img-responsive' ]); ?>

    </div>
    <div class="col-md-6">
        <?php echo HTML::image('webroot/img/cards2.png', 'Cards', [ 'class' => 'img img-responsive' ]); ?>

    </div>
</div>
<br />
<br />
<?php echo BootForm::open($attrsForm); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo BootForm::text('nombreTitular', 'Nombre del titular', null, [ 'data-checkout' => 'cardholderName', 'class' => 'nombre-tarjeta', 'required' => true ]); ?>

        </div>
        <div class="col-md-6">
            <?php echo BootForm::text(null, 'Numero de Tarjeta', null, [ 'data-checkout' => 'cardNumber', 'maxlength' => 16 , 'class' => 'numero-tarjeta', 'required' => true, 'id'=>'cardNumber' ]); ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php $meses = [
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12',
            ]; $__data['meses'] = [
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12',
            ]; ?>
            <?php echo BootForm::select(null, 'Mes de Expiración', $meses, null, [ 'data-checkout' => 'cardExpirationMonth', 'class' => 'mes-tarjeta', 'id'=>'cardExpirationMonth' ]); ?>

        </div>
        <div class="col-md-4">
            <?php $anios = [
                '18' => '2018',
                '19' => '2019',
                '20' => '2020',
                '21' => '2021',
                '22' => '2022',
                '23' => '2023',
                '24' => '2024',
                '25' => '2025',
                '26' => '2026',
                '27' => '2027',
                '28' => '2028',
                '29' => '2029',
                '31' => '2031',
                '32' => '2032',
                '33' => '2033',
                '34' => '2034',
                '35' => '2035',
                '36' => '2036',
                '37' => '2037',
                '38' => '2038',
                '39' => '2039',
            ]; $__data['anios'] = [
                '18' => '2018',
                '19' => '2019',
                '20' => '2020',
                '21' => '2021',
                '22' => '2022',
                '23' => '2023',
                '24' => '2024',
                '25' => '2025',
                '26' => '2026',
                '27' => '2027',
                '28' => '2028',
                '29' => '2029',
                '31' => '2031',
                '32' => '2032',
                '33' => '2033',
                '34' => '2034',
                '35' => '2035',
                '36' => '2036',
                '37' => '2037',
                '38' => '2038',
                '39' => '2039',
            ]; ?>
            <?php echo BootForm::select(null, 'Año de Expiración', $anios, null, [ 'data-checkout' => 'cardExpirationYear', 'class' => 'anio-tarjeta', 'id'=>'cardExpirationYear' ]); ?>

        </div>
        <div class="col-md-4">
            <?php echo BootForm::password(null, 'Codigo de Seguridad', [ 'data-checkout' => 'securityCode', 'maxlength' => 4, 'required' => true, 'class' => 'cvv-tarjeta', 'id'=>'securityCode' ]); ?>

            <?php echo HTML::image('webroot/img/cvv.png', 'Cards', [ 'class' => 'img img-responsive' ]); ?>

        </div>
    </div>
    <p>*Los precios no incluyen IVA</p>
    <?php if($tipo === 'CONTABILIDAD'): ?>
        <input type="hidden" name="estatus" id="estatus" class="estatus" value="<?php echo e($estatus); ?>">
        
        <input type="hidden" name="userId" id="user-id" class="user-id" value="<?php echo e(isset($user) ? $user->getId() : ''); ?>">
        <?php echo Label::success('Primer mes Gratuito'); ?>

        <?php /*!! BootForm::radios('tipoPlan', 'Tipo de Plan', \App\Models\UsersPagosContabilidad::getTiposPlanes(isset($user) ? $user: null) , null, null, [ 'class' => 'tipoPlan', 'required' => true ]) !!}
        <?php echo BootForm::text('mesesAnteriores', 'Elige el mes a contabilizar:', null, [ 'class' => 'meses']) !!*/ ?>
        <?php $mesesRegularizacion = [
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12',
        ]; $__data['mesesRegularizacion'] = [
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12',
        ]; ?>
        <?php $aniosRegularizacion = [
            '18' => '2018',
            '17' => '2017',
            '16' => '2016',
            '15' => '2015',
            '14' => '2014',
            '13' => '2013',
            '12' => '2012',
        ]; $__data['aniosRegularizacion'] = [
            '18' => '2018',
            '17' => '2017',
            '16' => '2016',
            '15' => '2015',
            '14' => '2014',
            '13' => '2013',
            '12' => '2012',
        ]; ?>
        <a href="#" class="btn btn-primary elegir-regularizacion" style="display:none">Elegir mes a contabilizar</a>
        <div class="seleccion-regularizacion">
            <div class="row hide">
                <div class="col-md-3">
                    {!! BootForm::select('mesRegularizacion[]', 'Mes', $mesesRegularizacion, null, [ 'class' => 'mes-regularizacion' ]); ?>

                    <span style="color:red; display:block; margin-top:-20px;"></span>
                </div>
                <div class="col-md-3">
                    <?php echo BootForm::select('anioRegularizacion[]', 'Año Regularizacion', $aniosRegularizacion, null, [ 'class' => 'anio-regularizacion' ]); ?>

                </div>
            </div>
        </div>
        <div class="contenido-regularizacion">
        </div>
        <h3>Resumen de Pago</h3>
        <table id="contabilidad-resumen-pago" class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Meses</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Contabilidad</td>
                    <td class="contabilidad-meses">1</td>
                    <td class="contabilidad-total">599.00</td>
                </tr>
                <!--<tr>
                    <td>Meses Anteriores</td>
                    <td class="anteriores-meses"></td>
                    <td class="anteriores-total"></td>
                </tr>-->
                <tr>
                    <td colspan="4" class="text-center"><h3>Total: $<span class="total">599.00</span></h3></td>
                </tr>
            </tbody>
        </table>
        <br />
    <?php else: ?>
        <h3>Resumen de Pago</h3>
        <table id="timbres-resumen-pago" class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Timbres</td>
                    <td class="timbres-paquete"></td>
                    <td class="timbres-total"></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center"><h3>Total: $<span class="total"></span></h3></td>
                </tr>
            </tbody>
        </table>
        <?php echo BootForm::text('precio', 'Precio', null, [ 'class' => 'nombre-tarjeta', 'required' => true ]); ?>

       <!-- <?php echo BootForm::radios('cantidad', 'Cantidad de Timbres', [ '50' => '50 Timbres, $10', '100' => '100 Timbres, $220', '200' => '200 Timbres, $380', '500' => '500 Timbres, $750', '1000' => '1000 Timbres, $1200', '2000' => '2000 Timbres, $2200', '4000' => '4000 Timbres, $4000', '5000' => '5000 Timbres, $4750' ], null, null, [ 'required' => true, 'class' => 'cantidad' ]); ?>-->
    <?php endif; ?>
    <br />
    <?php echo BootForm::checkbox('terminosCondiciones', 'Aceptar Términos y Condiciones', 'TERMINOS', null, [ 'class' => 'terminosCondiciones', 'required' => true ]); ?>

    <div class="row">
        <div class="col-md-3">
            <h4>Transacciones realizadas vía:</h4>
            <?php echo HTML::image('https://secure.mlstatic.com/components/resources/newmp/desktop/css/assets/nwmp-desktop-logo-mercadopago.png', 'Cards', [ 'class' => 'img img-responsive' ]); ?>

        </div>
        <div class="col-md-3">
            <h4>
                Tus pagos se realizan de forma segura con encriptación de 256 bits
            </h4>
            <?php echo HTML::image('webroot/img/security.png', 'Cards', [ 'class' => 'img img-responsive' ]); ?>

        </div>
    </div>
    <?php echo BootForm::checkbox('requieroFactura', 'Requiero Factura', 'REQUIERO_FACTURA', null, [ 'class' => 'requiero-factura' ]); ?>

    <?php echo BootForm::submit('Aceptar', [ 'class' => 'btn btn-primary legitRipple pago', 'data-loading-text' => "Procesando.." ]);; ?>

<?php echo BootForm::close();; ?>



