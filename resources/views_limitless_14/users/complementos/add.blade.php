@section('title', 'Agregar Pago')

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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

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

    {!! HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0') !!}

    
    {!! HTML::script('assets/js/plugins/forms/validation/validate.min.js') !!}
    {!! HTML::script('assets/js/plugins/forms/selects/bootstrap_multiselect.js') !!}
    {!! HTML::script('assets/js/plugins/forms/selects/select2.min.js') !!}

@append

@section('content')

    <div id="modal-add-cliente" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Nuevo Cliente</h4>
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

    <h2>Complemento de Pago</h2>
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
                    {!! BootForm::text('fechaPago', 'Fecha de Pago', null, [ 'class' => 'datetimepicker' ]) !!}
                    <h2>Serie y Folio</h2>
                    {!! BootForm::text('serie', 'Serie', null, [ 'class' => 'serie' ]) !!}
                    {!! BootForm::text('folio', 'Folio', null, [ 'class' => 'folio' ]) !!}
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
                    <div class="col-md-4"><br><br><br><br><br></div>
                    <h2>CFDIs Relacionados</h2>
                    <div class="cont">
                        <p>Selecciona un cfdi que hayas timbrado en EasyTaxes anteriormente o llena los datos manualmente.</p>
                        <div class="form-group">
                            <div class="radio">
                                <label><input type="radio" name="opcioncfdi" value="0">CFDI existente</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="opcioncfdi" value="1">Llenar datos</label>
                            </div>
                        </div>
                        <div class="clone">
                            <div class="cfdi-existente">
                                <p>Cargando cfdis...</p>
                            </div>
                            <div class="cfdi-nuevo">
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {!! BootForm::text('fUuid', 'UUID', null, ['class'=>'cfdi-uuid llenar','readonly' => 'readonly']) !!}
                                    <div class="mensaje-uuid" style="color:red"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    {!! BootForm::text('fSerie','Serie',null, ['class'=>'cfdi-serie llenar', 'readonly'=>'readonly']) !!}
                                    {!! BootForm::text('fFolio','Folio',null, ['class'=>'cfdi-folio llenar', 'readonly'=>'readonly']) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::select('fMoneda', 'Moneda del cfdi', [ 'MXN' => 'MXN', 'USD' => 'USD' ], [], [ 'class' => 'cfdi-moneda llenar' ]) !!}
                                    {!! BootForm::select('fMetodoPago', 'Método de pago del cfdi', \App\Models\Facturas::getMetodosPago(), [ 'class' => 'cfdi-metodoPago llenar' ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('fMonto','Saldo por pagar',null, ['class'=>'cfdi-saldoInsoluto llenar', 'readonly'=>'readonly']) !!}
                                    <div class="mensaje-saldo" style="color:red"></div>
                                    {!! BootForm::text('fParcialidad','Parcialidad',null, ['clas'=>'cfdi-parcialidad', 'readonly'=>'readonly']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    {!! BootForm::text('montoPago', 'Monto a pagar', null, [ 'class' => 'monto-pago' ]) !!}
                                    <div class="mensaje-monto" style="color:red"></div>
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::select('formaPago', 'Forma de Pago', \App\Models\Facturas::getFormasPago(), [ 'class' => 'forma-pago', 'required' => 'required' ]) !!}
                                    <div class="mensaje-pago" style="color:red"></div>
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::select('tipoMoneda', 'Moneda del pago', [ 'MXN' => 'MXN', 'USD' => 'USD' ], [], [ 'class' => 'tipo-moneda' ]) !!}
                                    <div class="cont-tipo-moneda">
                                        {!! BootForm::text('tipoCambio', 'Tipo de Cambio', null, [ 'class' => 'tipo-cambio' ]) !!}
                                    </div>
                                </div>
                            </div>
                            {!! HTML::link('#', '<i class="icmn-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar' ]) !!}
                            <br><br>
                        </div>
                        <div class="mensaje" style="color:red"></div>
                        <div class="table-responsive">
                            <table class="table table-cfdis">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Pago</th>
                                        <th>Saldo</th>
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
                            <h4><strong>Comprobante: </strong>Complemento de pago</h4>
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
                            <h2><strong>Pagos</strong></h2>
                            <div class="clone-cfdis"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-8">
                        </div>
                        <div class="col-md-3 col-md-offset-8">
                            <h2 class="text-right"><strong>Importes</strong></h2>
                            <div class="clone-importes text-right">
                                <p class="Csubtotal">Total importe anterior: <span></span></p>
                                <p class="Cpago">Total pago: <span></span></p>
                                <p class="Cnuevo-subtotal">Total nuevo importe: <span></span></p>
                            </div>
                            <h2 class="Ctotal text-right"><strong>Total pago recibido:</strong> <span></span></h2>
                            <input type="submit" class="btn btn-primary" style="float:right" value="Timbrar Pago">
                            <br />
                            <br />
                            <br />
                        </div>
                    </div>
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
    {!! HTML::scriptLocal('webroot/js/limitless_14/complementosv33_add_cleanui.js') !!}
@append
