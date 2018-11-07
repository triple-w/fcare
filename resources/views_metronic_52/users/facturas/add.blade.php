@section('title', 'Agregar Factura')

@section('styles')

    <!-- CSS -->
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/font-awesome/css/font-awesome.css') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/socialize-bookmarks.css') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/fancybox/source/jquery.fancybox.css?v=2.1.4') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/font-awesome/css/font-awesome.css') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/check_radio/skins/square/aero.css') !!}

    <!-- Toggle Switch -->
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/jquery.switch.css') !!}

    <!-- Owl Carousel Assets -->
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/owl.carousel.css') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/owl.theme.css') !!}

    <!-- Google web font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <style>
        .ui-widget { }
        .ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button {}
        .ui-widget-content { background: #fff; color: #222222; }
        .ui-widget-content a { color: #222222; }
        .ui-widget-header {background: #f68e56; }
        .ui-widget-header a { color: #222222; }
        .ui-progressbar { height:2em; text-align: left; }
        .ui-progressbar .ui-progressbar-value {margin: -1px; height:100%; }

        #bottom-wizard {
            text-align:center;
            padding:15px 120px;
            border-top:1px solid #e7e7e7;
            background-color:#f3f3f3;
        }

        #bottom-wizard {padding:15px 30px;}



        /*#bottom-wizard {margin}*/

    </style>

@append

@section('scripts')

    {!! HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/jquery-ui-1.8.22.min.js') !!}

    <!-- Wizard-->
    {!! HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/jquery.wizard.js') !!}

    <!-- Radio and checkbox styles -->
    {!! HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/check_radio/jquery.icheck.js') !!}

    <!-- HTML5 and CSS3-in older browsers-->
    {!! HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/modernizr.custom.17475.js') !!}

    <!-- Support media queries for IE8 -->
    {!! HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/respond.min.js') !!}

    {!! HTML::scriptLocal('webroot/js/limitless_14/facturas_add.js') !!}
    {!! HTML::script('assets/js/plugins/forms/validation/validate.min.js') !!}
    {!! HTML::script('assets/js/plugins/forms/selects/bootstrap_multiselect.js') !!}
    {!! HTML::script('assets/js/plugins/forms/selects/select2.min.js') !!}

@append

@section('content')

    <div id="modal-add-cliente" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Nuevo Cliente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
            {!! BootForm::open([ 'id' => 'form-agregar-cliente' ]) !!}
                  <div class="modal-body">
                    <input type="hidden" name="tipo" value="" />
                    <input type="hidden" name="id" value="" />
                    {!! BootForm::text('rfc', 'RFC', null, [
                        'data-validation' => '[NOTEMPTY, L<30]',
                        'data-validation-message' => 'Campo requerido y máximo 15 caracteres',
                        'data-validation-regex' => '/^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]{3}$/',
                        'data-validation-regex-message' => 'RFC no válido',
                    ]) !!}
                    {!! BootForm::text('razonSocial', 'Razon Social', null, [
                        'data-validation' => '[NOTEMPTY, L<200]',
                        'data-validation-message' => 'Campo requerido y máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('calle', 'Calle', null, [
                        'data-validation' => '[NOTEMPTY, L<90]',
                        'data-validation-message' => 'Campo requerido y máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('noExt', 'Numero Exterior', null, [
                        'data-validation' => '[NOTEMPTY, L<10]',
                        'data-validation-message' => 'Campo requerido y máximo 10 caracteres',
                    ]) !!}
                    {!! BootForm::text('noInt', 'Numero Interior', null, [
                        'data-validation' => '[OPTIONAL,L<10]',
                        'data-validation-message' => 'Máximo 10 caracteres',
                    ]) !!}
                    {!! BootForm::text('colonia', 'Colonia', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('municipio', 'Municipio', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('localidad', 'Localidad', null, [
                        'data-validation' => '[OPTIONAL,L<50]',
                        'data-validation-message' => 'Máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('estado', 'Estado', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('codigoPostal', 'Codigo Postal', null, [
                        'data-validation' => '[NOTEMPTY, L<10]',
                        'data-validation-message' => 'Campo requerido y máximo 10 caracteres',
                    ]) !!}
                    {!! BootForm::text('pais', 'Pais', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('telefono', 'Telefono', null, [
                        'data-validation' => '[NOTEMPTY, L<30]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('nombreContacto', 'Nombre de Contacto', null, [
                        'data-validation' => '[OPTIONAL,L<90]',
                        'data-validation-message' => 'Máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('email', 'Email', null, [
                        'data-validation' => '[OPTIONAL,EMAIL]',
                        'data-validation-message' => 'Email no válido',
                    ]) !!}
              </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Agregar">
            {!! BootForm::close(); !!}
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- <div class="alert alert-success mensaje-cliente-agregar" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Cliente agregado correctamente
    </div>

    <div class="alert alert-success mensaje-cliente-editar" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Cliente editado correctamente
    </div> --}}

    <!-- Start Survey container -->
    <div id="survey_container">

        <div id="top-wizard">
            <strong>Progreso <span id="location"></span></strong>
            <div id="progressbar"></div>
            <div class="shadow"></div>
        </div><!-- end top-wizard -->

        {!! BootForm::open([ 'id' => 'form-wizard' ]); !!}
            <div id="middle-wizard">
                <div class="step row">
                    <h2>Tipo de CFDI</h2>
                    {!! BootForm::select('nombreComprobante', 'Nombre de Comprobante', \App\Models\Facturas::getNombresDocumentos(), null, []) !!}
                    {!! BootForm::text('fechaFactura', 'Fecha de Factura', null, [ 'class' => 'datetimepicker' ]) !!}
                </div>
                <div class="step row">
                    <h2>Cliente</h2>
                    @set('clientes', [])
                    @foreach (Auth::user()->getClientes() as $cliente)
                        @set("clientes[$cliente->getId()]", $cliente->getRazonSocial() . ' - ' . $cliente->getRfc())
                    @endforeach
                    <button id="nuevo-cliente" class="btn btn-success"><i class="icmn-plus2" aria-hidden="true"></i> Nuevo Cliente</button>
                    <button id="actualizar-cliente" class="btn btn-success"><i class="icmn-pencil5" aria-hidden="true"></i> Actualizar Cliente</button>
                    <div class="mensaje-cliente" style="color:red"></div>
                    {!! BootForm::select('cliente', 'Cliente', $clientes, [], [ 'id' => 'clientes', 'readonly' => 'readonly' ]) !!}
                    <div class="col-md-4">
                        {!! BootForm::text('rfc', 'RFC', null, [ 'class' => 'cliente-rfc recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('razonSocial', 'Razon Social', null, [ 'class' => 'cliente-razonSocial recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('calle', 'Calle', null, [ 'class' => 'cliente-calle recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('noExt', 'No Ext', null, [ 'class' => 'cliente-noExt recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('noInt', 'No Int', null, [ 'class' => 'cliente-noInt recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('colonia', 'Colonia', null, [ 'class' => 'cliente-colonia recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('municipio', 'Municipio', null, [ 'class' => 'cliente-municipio recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('localidad', 'Localidad', null, [ 'class' => 'cliente-localidad recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('estado', 'Estado', null, [ 'class' => 'cliente-estado recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('codigoPostal', 'Codigo Postal', null, [ 'class' => 'cliente-codigoPostal recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('pais', 'Pais', null, [ 'class' => 'cliente-pais recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('telefono', 'Telefono', null, [ 'class' => 'cliente-telefono recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('nombreContacto', 'Nombre de Contacto', null, [ 'class' => 'cliente-nombreContacto recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::text('email', 'Email', null, [ 'class' => 'cliente-email recolect-cliente', 'readonly' => 'readonly' ]) !!}
                    </div>
                </div>
                <div class="step row">
                    <h2>Productos</h2>
                    @set('productos', [])
                    @foreach (Auth::user()->getProductos() as $producto)
                        @set("productos[$producto->getId()]", "{$producto->getClave()} - {$producto->getDescripcion()}")
                    @endforeach
                    <div class="cont">
                        <div class="clone">
                            {!! BootForm::select('nProductos', 'Producto', $productos, [], [ 'id' => 'productos' ]) !!}
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    {!! BootForm::text('nUnidadProducto', 'Unidad de Producto', null, [ 'id' => 'unidad_producto' ]) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! BootForm::text('nClaveProducto', 'Clave de Producto', null, [ 'id' => 'clave_producto' ]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! BootForm::text('nDescripcionProducto', 'Descripción de Producto', null, [ 'id' => 'descripcion_producto' ]) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! BootForm::text('nObservacionesProducto', 'Observaciones de Producto', null, [ 'id' => 'observaciones_producto' ]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    {!! BootForm::text('nPrecio', 'Precio', null, [ 'id' => 'precio', 'class' => 'fixed-to-2' ]) !!}
                                    <div class="mensaje-precio" style="color:red"></div>
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('nCantidad', 'Cantidad', '1', [ 'id' => 'cantidad' ]) !!}
                                    <div class="mensaje-cantidad" style="color:red"></div>
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::select('nProductosTipoImpuesto', 'Quiere desglosar el I.V.A.?', [ '1' => 'Si', '0' => 'No' ], [], [ 'id' => 'tipo-impuesto' ]) !!}
                                </div>
                            </div>
                            {!! HTML::link('#', '<i class="icmn-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar' ]) !!}
                            <br />
                            <br />
                        </div>
                        <div class="mensaje" style="color:red"></div>
                        <div class="table-responsive">
                            <table class="table table-productos">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Quiere desglosar el I.V.A.?</th>
                                        {{-- <th>IVA</th> --}}
                                        <th>Importe</th>
                                        <th class="delete">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <p class="subtotal" style="text-align:right"><strong>Subtotal: </strong><span></span></p>
                    </div>
                </div>
                <div class="step row">
                    <h2>Impuestos</h2>
                    <div class="row">
                        <div class="col-md-6">
                            {!! BootForm::text('tasaImpuestosTras[IVA]', 'IVA trasladado %', '16.00', [ 'class' => 'iva-trasladado fixed-to-2' ]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! BootForm::text('valorImpuestosTras[IVA]', 'IVA trasladado Valor', '0.00', [ 'class' => 'valor-iva' ]) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            {!! BootForm::text('tasaImpuestosTras[IEPS]', 'IEPS trasladado %', '', [ 'class' => 'ieps-trasladado fixed-to-2' ]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! BootForm::text('valorImpuestosTras[IEPS]', 'IEPS trasladado Valor', '', [ 'class' => 'ieps-trasladado-valor' ]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! BootForm::text('tipoImpuestosRet[IVA]', 'IVA retenido', '', [ 'class' => 'iva-retenido' ]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! BootForm::text('tipoImpuestosRet[ISR]', 'ISR retenido', '', [ 'class' => 'isr-retenido' ]) !!}
                        </div>
                    </div>

                    @set('impuestos', [])
                    @foreach (\App\Models\Impuestos::findBy([ 'user' => Auth::user() ]) as $impuesto)
                        @set("impuestos[$impuesto->getId()]", "{$impuesto->getNombre()} - {$impuesto->getTasa()} - {$impuesto->getTipo()}")
                    @endforeach
                    <div class="row">
                        <div class="col-md-6">
                            {!! BootForm::select('nImpuestos', 'Impuesto', $impuestos, [], [ 'id' => 'nImpuestos' ]) !!}
                        </div>
                        <div class="col-md-6">
                            {{-- {!! BootForm::text('nValorImpuesto', 'Valor de Impuesto', null, [ 'id' => 'clave_producto' ]) !!} --}}
                        </div>
                    </div>
                    {!! HTML::link('#', '<i class="icmn-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar-impuesto' ]) !!}
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table table-impuestos" id="table-impuestos">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Tasa %</th>
                                    <th class="delete">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <h2>Datos CFDI</h2>
                    {!! BootForm::text('formaPago', 'Forma de Pago *', 'Pago en una sola exhibición', [ 'class' => 'forma-pago', 'required' => 'required' ]) !!}
                    <div class="mensaje-pago" style="color:red"></div>
                    <div class="row">
                        <div class="col-md-4">
                            @set('radios', [ 'porcentaje' => '%', 'directo' => 'Directo' ])
                            {!! BootForm::radios('tipoDescuento', 'Tipo de descuento', $radios, 'porcentaje', [ 'style' => 'margin-left:5px' ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! BootForm::text('descuento', 'Descuento', '0.00', [ 'class' => 'descuento fixed-to-2' ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! BootForm::text('motivoDescuento', 'Motivo de Descuento', 'no aplica', [ 'class' => 'motivo-descuento' ]) !!}
                        </div>
                    </div>
                    {!! BootForm::select('tipoMoneda', 'Tipo de Moneda', [ 'MXN' => 'MXN', 'USD' => 'USD' ], [], [ 'id' => 'select-tipo-moneda' ]) !!}
                    <div class="cont-tipo-moneda">
                        {!! BootForm::text('tipoCambio', 'Tipo de Cambio', null, [ 'class' => 'tipo-moneda' ]) !!}
                    </div>
                    {!! BootForm::select('metodoPago', 'Metodo de Pago', [
                        '01' => 'EFECTIVO',
                        '02' => 'CHEQUE NOMINATIVO',
                        '03' => 'TRANSFERENCIA',
                        '04' => 'TARJETAS DE CREDITO',
                        '05' => 'MONEDEROS ELECTRONICOS',
                        '06' => 'DINERO ELECTRONICO',
                        '07' => 'TARJETAS DIGITALES',
                        '08' => 'VALES DE DESPENSA',
                        '09' => 'BIENES',
                        '10' => 'SERVICIO',
                        '11' => 'POR CUENTA DE TERCERO',
                        '12' => 'DACIÓN EN PAGO',
                        '13' => 'PAGO POR SUBROGACIÓN',
                        '14' => 'PAGO POR CONSIGNACIÓN',
                        '15' => 'CONDONACIÓN',
                        '16' => 'CANCELACIÓN',
                        '17' => 'COMPENSACIÓN',
                        //'28' => 'TARJETA DE DEBITO',
                        //'29' => 'TARJETA DE SERVICIOS',
                        '98' => 'NA',
                        '99' => 'OTROS',
                    ], [], [ 'class' => 'metodo-pago' ]) !!}
                    {!! BootForm::text('numeroCuentaPago', 'Numero de Cuenta de Pago', null, [ 'class' => 'numero-cuenta' ]) !!}
                    {!! BootForm::textarea('comentariosPDF', 'Comentarios en PDF', null, [ 'class' => 'comentarios-pdf' ]) !!}
                    <div class="mensaje-comentarios" style="color:red"></div>
                    {{-- {!! BootForm::text('folioFo', 'Folio FO', null, []) !!}
                    {!! BootForm::text('serieFolioFo', 'Serie de Folio FO', null, []) !!}
                    {!! BootForm::text('fechaFolioFo', 'Fecha de Folio FO', null, []) !!}
                    {!! BootForm::text('montoFolioFo', 'Monto de Folio FO', null, []) !!} --}}
                </div>
                <div class="step row">
                    <br />
                    <br />
                    <br />
                    <div class="row">
                        <div class="col-md-6">
                            <h4><strong>Comprobante: </strong><span class="Ccomprobante"></span></h4>
                        </div>
                        <div class="col-md-6">
                            <h4><strong>Fecha: </strong><span class="Cfecha-comprobante"></span></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2><strong>Cliente</strong></h2>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente">Cliente: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-rfc">RFC: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-razonSocial">Razon Social: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-calle">Calle: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-noExt">No Ext: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-noInt">No Int: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-colonia">Colonia: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-municipio">Municipio: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-localidad">Localidad: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-estado">Estado: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-codigoPostal">Codigo Postal: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-pais">Pais: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-telefono">Telefono: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-nombreContacto">Nombre de Contacto: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-email">Email: <span></span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2><strong>Productos</strong></h2>
                            <div class="clone-productos"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-8">
                            <h2 class="text-right"><strong>Impuestos</strong></h2>
                            <div class="clone-impuestos text-right">
                                <p class="Civa-trasladado">IVA Trasladado %: <span></span></p>
                                <p class="Cvalor-iva">IVA Trasladado Valor: <span></span></p>
                                <p class="Cieps-trasladado">IEPS Trasladado %: <span></span></p>
                                <p class="Civa-retenido">IVA Retenido %: <span></span></p>
                                <p class="Cisr-retenido">ISR Retenido %: <span></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-5">
                                <div class="clone-table-impuestos"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-8">
                            <h2 class="text-right"><strong>Importes</strong></h2>
                            <div class="clone-importes text-right">
                                <p class="Csubtotal">Subtotal: <span></span></p>
                                <p class="Cdescuento">Descuento: <span></span></p>
                                <p class="Cmotivo-descuento">Motivo de Descuento: <span></span></p>
                                <p class="Cnuevo-subtotal">Nuevo subtotal: <span></span></p>
                            </div>
                            <h2 class="Ctotal text-right"><strong>Total de factura:</strong> <span></span></h2>
                            <input type="submit" class="btn btn-primary" style="float:right" value="Facturar">
                            <br />
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
            </div>
            <div id="bottom-wizard">
                <button type="button" name="backward" class="btn btn-info backward"><i class="icmn-circle-left4" aria-hidden="true"></i></button>
                <button type="button" name="forward" class="btn btn-success forward"><i class="icmn-circle-right4" aria-hidden="true"></i></button>
            </div><!-- end bottom-wizard -->
        {!! BootForm::close(); !!}

    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
