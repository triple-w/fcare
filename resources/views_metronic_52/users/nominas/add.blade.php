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

    {!! HTML::scriptLocal('webroot/js/limitless_14/nominas_add.js') !!}
    {!! HTML::script('assets/js/plugins/forms/validation/validate.min.js') !!}
    {!! HTML::script('assets/js/plugins/forms/selects/bootstrap_multiselect.js') !!}
    {!! HTML::script('assets/js/plugins/forms/selects/select2.min.js') !!}

@append

@section('content')

    <div id="modal-add-empleado" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Nuevo Empleado</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
            {!! BootForm::open([ 'id' => 'form-agregar-empleado' ]) !!}
                  <div class="modal-body">
                    <input type="hidden" name="tipo" value="" />
                    <input type="hidden" name="id" value="" />
                    {!! BootForm::text('nombre', 'Nombre', null, [
                        'data-validation' => '[NOTEMPTY, L<90]',
                        'data-validation-message' => 'Campo requerido y máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('rfc', 'RFC', null, [
                        'data-validation' => '[NOTEMPTY, L<30]',
                        'data-validation-message' => 'Campo requerido y máximo 15 caracteres',
                        'data-validation-regex' => '/^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]{3}$/',
                        'data-validation-regex-message' => 'RFC no válido',
                    ]) !!}
                    {!! BootForm::text('curp', 'CURP', null, [
                        'data-validation' => '[NOTEMPTY, L<200]',
                        'data-validation-message' => 'Campo requerido y máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('numSeguroSocial', 'Numero de Seguridad Social', null, [
                        'data-validation' => '[NOTEMPTY, L<90]',
                        'data-validation-message' => 'Campo requerido y máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('calle', 'Calle', null, [
                        'data-validation' => '[NOTEMPTY, L<90]',
                        'data-validation-message' => 'Campo requerido y máximo 10 caracteres',
                    ]) !!}
                    {!! BootForm::text('localidad', 'Localidad', null, [
                        'data-validation' => '[NOTEMPTY,L<30]',
                        'data-validation-message' => 'Máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('noExterior', 'Numero Exterior', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('noInterior', 'Numero Interior', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('referencia', 'Referencia', null, [
                        'data-validation' => '[NOTEMPTY,L<90]',
                        'data-validation-message' => 'Máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('colonia', 'Colonia', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::select('estado', 'Estado', \App\Models\Empleados::getEntidadFederativa(), null, []) !!}
                    {!! BootForm::text('municipio', 'Municipio', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 50 caracteres',
                    ]) !!}
                    {!! BootForm::text('pais', 'Pais', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('codigoPostal', 'Codigo Postal', null, [
                        'data-validation' => '[NOTEMPTY, L<30]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]) !!}
                    {!! BootForm::text('telefono', 'Telefono', null, [
                        'data-validation' => '[OPTIONAL,L<90]',
                        'data-validation-message' => 'Máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('email', 'Email', null, [
                        'data-validation' => '[OPTIONAL,EMAIL]',
                        'data-validation-message' => 'Email no válido',
                    ]) !!}
                    {!! BootForm::text('registroPatronal', 'Registro Patronal', null, [
                        'data-validation' => '[NOTEMPTY,L<90]',
                        'data-validation-message' => 'Máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::select('tipoContrato', 'Tipo de Contrato', \App\Models\Empleados::getTipoContratos(), null, []) !!}
                    {!! BootForm::text('numeroEmpleado', 'Numero de Empleado', null, [
                        'data-validation' => '[NOTEMPTY,L<90]',
                        'data-validation-message' => 'Máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::select('riesgoPuesto', 'Riesgo de Puesto',\App\Models\Empleados::getRiesgoPuestos(), null, []) !!}
                    {!! BootForm::select('tipoJornada', 'Tipo de Jornada', \App\Models\Empleados::getTipoJornadas(), null, []) !!}
                    {!! BootForm::text('puesto', 'Puesto', null, [
                        'data-validation' => '[NOTEMPTY,L<90]',
                        'data-validation-message' => 'Máximo 90 caracteres',
                    ]) !!}
                    {!! BootForm::text('fechaInicioLaboral', 'Fecha de Inicio Laboral', null, [
                        'data-validation' => '[NOTEMPTY]',
                        'data-validation-message' => 'Campo requerido',
                        'class' => 'datepicker',
                    ]) !!}
                    {!! BootForm::select('tipoRegimen', 'Tipo de Regimen', \App\Models\Empleados::getTipoRegimenes(), null, []) !!}
                    {!! BootForm::text('salario', 'Salario', null, [
                        'data-validation' => '[NOTEMPTY]',
                        'data-validation-message' => 'Campo requerido',
                    ]) !!}
                    {!! BootForm::select('periodicidadPago', 'PariodicidadPago', \App\Models\Empleados::getPeriodicidadPagos(), null, []) !!}
                    {!! BootForm::text('salarioDiarioIntegrado', 'Salario Diario Integrado', null, [
                        'data-validation' => '[NOTEMPTY]',
                        'data-validation-message' => 'Campo requerido',
                    ]) !!}
                    {!! BootForm::text('clabe', 'CLABE', null, [
                        'data-validation' => '[NOTEMPTY]',
                        'data-validation-message' => 'Campo requerido',
                    ]) !!}
                    {!! BootForm::select('banco', 'Banco', \App\Models\Empleados::getBancos(), null, []) !!}
              </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Agregar">
            {!! BootForm::close(); !!}
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="alert alert-success mensaje-empleado-agregar" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Empleado agregado correctamente
    </div>

    <div class="alert alert-success mensaje-empleado-editar" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Empleado editado correctamente
    </div>

    <div id="survey_container">
        <div id="top-wizard">
            <strong>Progreso <span id="location"></span></strong>
            <div id="progressbar"></div>
            <div class="shadow"></div>
        </div><!-- end top-wizard -->
        {!! BootForm::open([ 'id' => 'form-wizard' ]); !!}
            <div id="middle-wizard">
                <div class="step row">
                    <div class="col-md-12">
                    @set('empleados', [])
                    @foreach (Auth::user()->getEmpleados() as $empleado)
                        @set("empleados[$empleado->getId()]", "{$empleado->getNombre()} - {$empleado->getRfc()}")
                    @endforeach
                    {!! BootForm::select('empleado', 'Empleado', $empleados, null, [ 'id' => 'empleados' ]) !!}
                    <button id="nuevo-empleado" class="btn btn-success"><i class="icmn-plus2" aria-hidden="true"></i> Nuevo Empleado</button>
                    <button id="actualizar-empleado" class="btn btn-success"><i class="icmn-pencil5" aria-hidden="true"></i> Actualizar Empleado</button>
                    <div class="mensaje-empleado" style="color:red"></div>
                    <div class="row">
                    <div class="col-md-3">
                        {!! BootForm::text('nombre', 'Nombre', null, [ 'class' => 'recolect-empleado empleado-nombre', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('rfc', 'RFC', null, [ 'class' => 'recolect-empleado empleado-rfc', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('curp', 'CURP', null, [ 'class' => 'recolect-empleado empleado-curp', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('numSeguroSocial', 'Numero de Seguro Social', null, [ 'class' => 'recolect-empleado empleado-numSeguroSocial', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('calle', 'Calle', null, [ 'class' => 'recolect-empleado empleado-calle', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('localidad', 'Localidad', null, [ 'class' => 'recolect-empleado empleado-localidad', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('noExterior', 'No Exterior', null, [ 'class' => 'recolect-empleado empleado-noExterior', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('noInterior', 'No Interior', null, [ 'class' => 'recolect-empleado empleado-noInterior', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('referencia', 'Referencia', null, [ 'class' => 'recolect-empleado empleado-referencia', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('colonia', 'Colonia', null, [ 'class' => 'recolect-empleado empleado-colonia', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::select('estado', 'Estado', \App\Models\Empleados::getEntidadFederativa(), null, [ 'class' => 'recolect-empleado empleado-estado', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('municipio', 'Municipio', null, [ 'class' => 'recolect-empleado empleado-municipio', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('pais', 'Pais', null, [ 'class' => 'recolect-empleado empleado-pais', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('codigoPostal', 'Codigo Postal', null, [ 'class' => 'recolect-empleado empleado-codigoPostal', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('telefono', 'Telefono', null, [ 'class' => 'recolect-empleado empleado-telefono', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('email', 'Email', null, [ 'class' => 'recolect-empleado empleado-email', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('registroPatronal', 'Registro Patronal', null, [ 'class' => 'recolect-empleado empleado-registroPatronal', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::select('tipoContrato', 'Tipo de Contrato', \App\Models\Empleados::getTipoContratos(), null, [ 'class' => 'recolect-empleado empleado-tipoContrato', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('numeroEmpleado', 'Número de Empleado', null, [ 'class' => 'recolect-empleado empleado-numeroEmpleado', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::select('riesgoPuesto', 'Riesgo de Puesto',\App\Models\Empleados::getRiesgoPuestos(), null, [ 'class' => 'recolect-empleado empleado-riesgoPuesto', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::select('tipoJornada', 'Tipo de Jornada', \App\Models\Empleados::getTipoJornadas(), null, [ 'class' => 'recolect-empleado empleado-tipoJornada', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('puesto', 'Puesto', null, [ 'class' => 'recolect-empleado empleado-puesto', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('fechaInicioLaboral', 'Fecha de inicio de Labores', null, [ 'class' => 'recolect-empleado empleado-fechaInicioLaboral', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::select('tipoRegimen', 'Tipo de Regimen', \App\Models\Empleados::getTipoRegimenes(), null, [ 'class' => 'recolect-empleado empleado-tipoRegimen', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('salario', 'Salario', null, [ 'class' => 'recolect-empleado empleado-salario', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::select('periodicidadPago', 'PariodicidadPago', \App\Models\Empleados::getPeriodicidadPagos(), null, [ 'class' => 'recolect-empleado empleado-periodicidadPago', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('salarioDiarioIntegrado', 'Salaro diario Integrado', null, [ 'class' => 'recolect-empleado empleado-salarioDiarioIntegrado', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::text('clabe', 'CLABE', null, [ 'class' => 'recolect-empleado empleado-clabe', 'readonly' => 'readonly' ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! BootForm::select('banco', 'Banco', \App\Models\Empleados::getBancos(), null, [ 'class' => 'recolect-empleado empleado-banco', 'readonly' => 'readonly' ]) !!}
                    </div>
                    </div>
                </div>
                </div>
                <div class="step row">
                    <div class="col-md-12"> 
                    {!! BootForm::select('regimen', 'Regimen', \App\Models\Nominas::getRegimenes(), null, []) !!}
                    {!! BootForm::text('fechaPago', 'Fecha de Pago', null, [ 'class' => 'datepicker' ]) !!}
                    {!! BootForm::text('fechaInicialPago', 'Fecha Inicial de Pago', null, [ 'class' => 'datepicker' ]) !!}
                    {!! BootForm::text('fechaFinalPago', 'Fecha Final de Pago', null, [ 'class' => 'datepicker' ]) !!}
                    {!! BootForm::text('numDiasPagados', 'Numero de dias Pagados', null, []) !!}
                    {!! BootForm::checkbox('sindicalizado', 'Sindicalizado', 1, null, [ 'class' => 'sindicalizado' ]) !!}
                    {!! BootForm::checkbox('sncf', 'SNCF', 1, null, [ 'class' => 'sncf' ]) !!}
                    {!! BootForm::select('sncfOrigen', 'SNCF Origen', [ 'IP' => 'Ingresos Propios', 'IF' => 'Ingresos Federales', 'IM' => 'Ingresos Mixtos' ], null, [ 'class' => 'sncf_origen' ]) !!}
                    {!! BootForm::text('sncfMonto', 'SNCF Monto', null, [ 'class' => 'sncf_monto']) !!}
                    </div>
                </div>
                <div class="step row">
                    <h3>Percepciones</h3>
                    <div class="cont">
                        <div class="clone">
                            <div class="row">
                                <div class="col-md-3">
                                    {!! BootForm::text('clave', 'Clave', null, [ 'id' => 'clave' ]) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! BootForm::select('concepto', 'Concepto', \App\Models\Nominas::getConceptos(), null, []) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! BootForm::text('importeGravado', 'Importe Gravado', null, [ 'id' => 'importe_gravado' ]) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! BootForm::text('importeExcento', 'Importe Excento', null, [ 'id' => 'importe_excento' ]) !!}
                                </div>
                            </div>
                            {!! HTML::link('#', '<i class="icmn-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar-percepciones' ]) !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-percepciones">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Concepto</th>
                                    <th>Importe Gravado</th>
                                    <th>Importe Excento</th>
                                    <th class="delete">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="step row">
                    <h3>Deducciones</h3>
                    <div class="cont">
                        <div class="clone">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! BootForm::text('clave', 'Clave', null, [ 'id' => 'clave' ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::select('concepto', 'Concepto', \App\Models\Nominas::getConceptosDeducciones(), null, []) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('importe', 'Importe', null, [ 'id' => 'importe' ]) !!}
                                </div>
                            </div>
                            {!! HTML::link('#', '<i class="icmn-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar-deducciones' ]) !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-deducciones">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                    <th class="delete">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="step row">
                    <h3>Otros Pagos</h3>
                    <div class="cont">
                        <div class="clone">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! BootForm::text('clave', 'Clave', null, [ 'id' => 'clave' ]) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::select('concepto', 'Concepto', \App\Models\Nominas::getOtrosPagosOptions(), null, []) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! BootForm::text('importe', 'Importe', null, [ 'id' => 'importe' ]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    {!! BootForm::text('subsidioCausado', 'Subsidio Causado', null, [ 'id' => 'subsidio_causado' ]) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! BootForm::text('saldoFavor', 'Saldo a Favor', null, [ 'id' => 'saldo_favor' ]) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! BootForm::text('anio', 'Año', null, [ 'id' => 'anio' ]) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! BootForm::text('remanente', 'Remanenete Saldo a Favor', null, [ 'id' => 'remanente' ]) !!}
                                </div>
                            </div>
                            {!! HTML::link('#', '<i class="icmn-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar-otros-pagos' ]) !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-otros-pagos">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                    <th>Subsidio Causado</th>
                                    <th>Saldo a Favor</th>
                                    <th>Año</th>
                                    <th>Remanente</th>
                                    <th class="delete">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="step row">
                    <h3 class="resumen-perseciones-titulo">Percepciones</h3>
                    <div class="resumen-percepciones">
                    </div>
                    <h3 class="resumen-deducciones-titulo">Deducciones</h3>
                    <div class="resumen-deducciones">
                    </div>
                    <h3 class="resumen-otros-pagos-titulo">Otros Pagos</h3>
                    <div class="resumen-otros-pagos">
                    </div>
                    <h3 class="resumen-total-percepciones text-right">Total Percepciones: <strong></strong></h3>
                    <h3 class="resumen-total-deducciones text-right">Total Deducciones: <strong></strong></h3>
                    <h3 class="resumen-total-otros-pagos text-right">Total Otros Pagos: <strong></strong></h3>
                    <h3 class="resumen-total text-right">Total: <strong></strong></h3>
                    <input type="submit" class="btn btn-primary" style="float:right" value="Facturar">
                    <br />
                    <br />
                    <br />
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
