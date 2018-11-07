@section('title', 'Agregar Complemento')

@section('styles')

    <!-- CSS -->
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/socialize-bookmarks.css') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/fancybox/source/jquery.fancybox.css?v=2.1.4') !!}
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

    {!! HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js') !!}

    {!! HTML::scriptLocal('webroot/js/limitless_14/facturasV33_complementos_add.js?v=1.1.0') !!}
    {!! HTML::script('assets/js/plugins/forms/validation/validate.min.js') !!}
    {!! HTML::script('assets/js/plugins/forms/selects/bootstrap_multiselect.js') !!}
    {!! HTML::script('assets/js/plugins/forms/selects/select2.min.js') !!}

@append

@section('content')

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
                    {!! BootForm::select('usoCFDI', 'Uso de CFDI', \App\Models\Facturas::getUsosCFDI(), [], [ 'class' => 'uso-cfdi' ]) !!}
                </div>
                <div class="step row">
                    <h2>Cliente</h2>
                    @set('clientes', [])
                    @foreach (Auth::user()->getClientes() as $cliente)
                        @set("clientes[$cliente->getId()]", $cliente->getRazonSocial() . ' - ' . $cliente->getRfc())
                    @endforeach
                    <button id="nuevo-cliente" class="btn btn-success"><i class="icon-plus2" aria-hidden="true"></i> Nuevo Cliente</button>
                    <button id="actualizar-cliente" class="btn btn-success"><i class="icon-pencil5" aria-hidden="true"></i> Actualizar Cliente</button>
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
                            <h3>Información de Producto</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! BootForm::select('nClaveServProd', 'Clave de Servicio', [], [], [ 'id' => 'clave-prod-serv', 'data-url' => 'productos/clave-prod-serv' ]) !!}
                                    <input type="hidden" id="hclave-prod-serv" value=""/>
                                    <input type="hidden" id="hclave-prod-serv-text" value=""/>
                                </div>
                                <div class="col-md-6">
                                    {!! BootForm::select('nClaveUnidad', 'Clave de Unidad', [], [], [ 'id' => 'clave-unidad', 'data-url' => 'productos/clave-unidad' ]) !!}
                                    <input type="hidden" id="hclave-unidad" value=""/>
                                    <input type="hidden" id="hclave-unidad-text" value=""/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! BootForm::text('nUnidadProducto', 'Unidad de Producto', null, [ 'id' => 'unidad_producto' ]) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! BootForm::text('nClaveProducto', 'Clave de Producto', null, [ 'id' => 'clave_producto' ]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    {!! BootForm::text('nCantidad', 'Cantidad', '1', [ 'id' => 'cantidad' ]) !!}
                                    <div class="mensaje-cantidad" style="color:red"></div>
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('nDescripcionProducto', 'Descripción de Producto', null, [ 'id' => 'descripcion_producto' ]) !!}
                                </div>
                            </div>
                            {!! HTML::link('#', '<i class="icon-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar' ]) !!}
                            <br />
                            <br />
                        </div>
                        <div class="mensaje" style="color:red"></div>
                        <div class="table-responsive">
                            <table class="table table-productos">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Clave Servicio</th>
                                        <th>Clave Unidad</th>
                                        <th>Cantidad</th>
                                        <th class="delete">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="step row">
                    <h2>Facturas</h2>
                    @set('facturas', [])
                    @foreach (Auth::user()->getFacturas() as $factura)
                        @set("facturas[$factura->getId()]", "{$factura->getUuid()}")
                    @endforeach
                    <div class="cont">
                        <div class="clone">
                            {!! BootForm::select('nFacturas', 'Factura', $facturas, [], [ 'id' => 'facturas' ]) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    {!! BootForm::select('nMetodoPagoDR', 'Metodo de Pago', \App\Models\Facturas::getMetodosPago(), [], [ 'id' => 'metodo-pago-dr' ]) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! BootForm::text('nNumeroParcialidad', 'Numero de Parcialidad', null, [ 'id' => 'numero-parcialidad' ]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! BootForm::text('nSaldoAnterior', 'Saldo Anterior', null, [ 'id' => 'saldo-anterior' ]) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! BootForm::text('nImportePagado', 'Importe Pagado', null, [ 'id' => 'importe-pagado' ]) !!}
                                </div>
                            </div>
                            <h3>Impuestos Retenidos</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    {!! BootForm::text('nRetencionIVA', 'Retenciones IVA', '', [ 'id' => 'retencion-iva', 'class' => 'retencion-iva' ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('nRetencionISR', 'Retenciones ISR', '', [ 'id' => 'retencion-isr', 'class' => 'retencion-isr' ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('nRetencionIEPS', 'Retenciones IEPS', '', [ 'id' => 'retencion-ieps', 'class' => 'retencion-ieps' ]) !!}
                                </div>
                            </div>
                            <h3>Impuestos Trasladados</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    {!! BootForm::text('nTrasladadoIVA', 'Trasladados IVA', '', [ 'id' => 'traslado-iva', 'class' => 'trasladado-iva' ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('nTrasladadoISR', 'Trasladados ISR', '', [ 'id' => 'traslado-isr', 'class' => 'trasladado-isr' ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('nTrasladadoIEPS', 'Trasladados IEPS', '', [ 'id' => 'traslado-ieps', 'class' => 'trasladado-ieps' ]) !!}
                                </div>
                            </div>
                            {!! HTML::link('#', '<i class="icon-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar-factura' ]) !!}
                            <br />
                            <br />
                        </div>
                        <div class="table-responsive">
                            <table class="table table-facturas">
                                <thead>
                                    <tr>
                                        <th>UUID</th>
                                        <th>Saldo Anterior</th>
                                        <th>Pago</th>
                                        <th class="delete">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                    <div class="col-md-12">
                        <h2><strong>Facturas</strong></h2>
                        <div class="clone-facturas"></div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" style="float:right" value="Facturar">
            </div>
            </div>
            <div id="bottom-wizard">
                <button type="button" name="backward" class="btn btn-info backward"><</i></button>
                <button type="button" name="forward" class="btn btn-success forward">></i></button>
            </div><!-- end bottom-wizard -->
        {!! BootForm::close(); !!}

    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
