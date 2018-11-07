@section('title', 'Documentos Periodo')

@section('content')

    <div id="modal-datos-pagado" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Pagado</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
                <div class="mensaje hide">Hubo un error al actualizar el registro.</div>
                <h3>Periodo: {{ $periodo->getMes() }} - {{ $periodo->getAnio() }}</h3>
                {!! BootForm::open([ 'url' => action('Users\PeriodosController@postDocumentoPagado'), 'method' => 'POST', 'class' => 'documento-pagado' ]) !!}
                    <input type="hidden" class="documento-id" name="documento-id" value="">
                    {!! BootForm::select('deduccion', 'Deduccion', \App\Models\UsersPeriodosDocumentosPagos::getDeducciones(), null, [ 'class' => 'deduccion' ]) !!}
                    {!! BootForm::select('tipoGasto', 'Tipo de Gasto', \App\Models\UsersPeriodosDocumentosPagos::getTiposGastos(), null, [ 'class' => 'tipo-gasto' ]) !!}
                    {!! BootForm::select('clasificacion', 'Clasificacion', \App\Models\UsersPeriodosDocumentosPagos::getClasificaciones(), null, [ 'class' => 'clasificacion' ]) !!}
                    {!! BootForm::text('monto', 'Monto Pagado', '0', [ 'class' => 'monto-pagar' ]) !!}
                    {!! BootForm::submit('Aceptar') !!}
                {!! BootForm::close() !!}
          </div>
          <div class="modal-footer">
            <input type="hidden" id="href-eliminar" value="">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <!-- Basic tabs -->
            <div class="panel-body">
                <h3>Periodo: {{ $periodo->getMes() }} - {{ $periodo->getAnio() }}</h3>
                {!! BootForm::open([ 'url' => action('Users\PeriodosController@postTerminar'), 'method' => 'POST' ]) !!}
                    <div class="row">
                        <input type="hidden" name="mes" value="{{ $periodo->getMes() }}">
                        <input type="hidden" name="anio" value="{{ $periodo->getAnio() }}">
                    </div>
                    {!! BootForm::submit('Terminar Periodo Actual'); !!}
                {!! BootForm::close(); !!}
            </div>
        </div>
    </div>

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <!-- Basic tabs -->
            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="{{ $tipo === 'EMITIDO' ? 'active' : '' }}"><a href="#basic-tab1" data-toggle="tab">Ingresos</a></li>
                        <li class="{{ $tipo === 'RECIBIDO' ? 'active' : '' }}"><a href="#basic-tab2" data-toggle="tab">Egresos</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane {{ $tipo === 'EMITIDO' ? 'active' : '' }}" id="basic-tab1">
                            <h3>INGRESOS</h3>
                            <div class="margin-bottom-50">
                                <h3>Ingresos sin Factura: {{ $periodo->getIngresoSinFactura() }}</h3>
                                <div class="well">
                                    {!! BootForm::open([ 'url' => action('Users\PeriodosController@postUpdatePeriodo', [ 'id' => $periodo->getId() ]) ]) !!}
                                        {!! BootForm::text('ingresoSinFactura', 'Ingreso sin Factura', $periodo->getIngresoSinFactura(), []) !!}
                                        {!! BootForm::submit('Guardar'); !!}
                                    {!! BootForm::close(); !!}
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>UUID</th>
                                                <th>Fecha Emisión</th>
                                                <th>RFC Emisor</th>
                                                <th>Nombre Emisor</th>
                                                <th>RFC Receptor</th>
                                                <th>Nombre Receptor</th>
                                                <th>Pagado</th>
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        <tbody>
                                            @foreach ($emitidos as $documento)
                                                <tr>
                                                    <td>{{ $documento->getDatos()['uuid'] }}</td>
                                                    <td>{{ $documento->getDatos()['fechaEmision'] }}</td>
                                                    <td>{{ $documento->getDatos()['rfcEmisor'] }}</td>
                                                    <td>{{ $documento->getDatos()['nombreEmisor'] }}</td>
                                                    <td>{{ $documento->getDatos()['rfcReceptor'] }}</td>
                                                    <td>{{ $documento->getDatos()['nombreReceptor'] }}</td>
                                                    <td>${{ number_format($documento->getSumPagos(), 2, '.', ',') }}</td>
                                                    <td>{{ $documento->getDatos()['total'] }}</td>
                                                    <td>{{ $documento->getTipo() }}</td>
                                                    <td>{{ $documento->getEstatus() }}</td>
                                                    <td>
                                                        @if ($documento->getEstatus() !== \App\Models\UsersPeriodosDocumentos::PAGADO)
                                                            {!! HTML::link('#', '<i class="icon-cash" aria-hidden="true"></i>', [ 'class' => 'btn btn-default fecha-pagado', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Pagar', 'data-toggle' => 'modal', 'data-target' => '#modal-datos-pagado', 'data-id' => $documento->getId() ]) !!}
                                                        @endif
                                                        {!! HTML::link(action('Users\PeriodosController@getDeleteDocumento', [ 'id' => $documento->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane {{ $tipo === 'RECIBIDO' ? 'active' : '' }}" id="basic-tab2">
                            <h3>EGRESOS</h3>
                            <div class="margin-bottom-50">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>UUID</th>
                                                <th>Fecha Emisión</th>
                                                <th>RFC Emisor</th>
                                                <th>Nombre Emisor</th>
                                                <th>RFC Receptor</th>
                                                <th>Nombre Receptor</th>
                                                <th>Pagado</th>
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        <tbody>
                                            @foreach ($recibidos as $documento)
                                                <tr>
                                                    <td>{{ $documento->getDatos()['uuid'] }}</td>
                                                    <td>{{ $documento->getDatos()['fechaEmision'] }}</td>
                                                    <td>{{ $documento->getDatos()['rfcEmisor'] }}</td>
                                                    <td>{{ $documento->getDatos()['nombreEmisor'] }}</td>
                                                    <td>{{ $documento->getDatos()['rfcReceptor'] }}</td>
                                                    <td>{{ $documento->getDatos()['nombreReceptor'] }}</td>
                                                    <td>${{ number_format($documento->getSumPagos(), 2, '.', ',') }}</td>
                                                    <td>{{ $documento->getDatos()['total'] }}</td>
                                                    <td>{{ $documento->getTipo() }}</td>
                                                    <td>{{ $documento->getEstatus() }}</td>
                                                    <td>
                                                        @if ($documento->getEstatus() !== \App\Models\UsersPeriodosDocumentos::PAGADO)
                                                            {!! HTML::link('#', '<i class="icon-cash" aria-hidden="true"></i>', [ 'class' => 'btn btn-default fecha-pagado', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Pagar', 'data-toggle' => 'modal', 'data-target' => '#modal-datos-pagado', 'data-id' => $documento->getId() ]) !!}
                                                        @endif
                                                        {!! HTML::link(action('Users\PeriodosController@getDeleteDocumento', [ 'id' => $documento->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /basic tabs -->
        </div>
    </div>

    <h3>MESES ANTERIORES</h3>
    <div class="panel panel-flat panel-collapsed">
        <div class="panel-heading">
            <h5 class="panel-title"></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <!-- Basic tabs -->
            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="{{ $tipo === 'EMITIDO' ? 'active' : '' }}"><a href="#basic-tab3" data-toggle="tab">Ingresos</a></li>
                        <li class="{{ $tipo === 'RECIBIDO' ? 'active' : '' }}"><a href="#basic-tab4" data-toggle="tab">Egresos</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane {{ $tipo === 'EMITIDO' ? 'active' : '' }}" id="basic-tab3">
                            <h3>INGRESOS</h3>
                            <div class="margin-bottom-50">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>UUID</th>
                                                <th>Fecha Emisión</th>
                                                <th>RFC Emisor</th>
                                                <th>Nombre Emisor</th>
                                                <th>RFC Receptor</th>
                                                <th>Nombre Receptor</th>
                                                <th>Pagado</th>
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        <tbody>
                                            @foreach ($emitidosAnteriores as $documento)
                                                <tr>
                                                    <td>{{ $documento->getDatos()['uuid'] }}</td>
                                                    <td>{{ $documento->getDatos()['fechaEmision'] }}</td>
                                                    <td>{{ $documento->getDatos()['rfcEmisor'] }}</td>
                                                    <td>{{ $documento->getDatos()['nombreEmisor'] }}</td>
                                                    <td>{{ $documento->getDatos()['rfcReceptor'] }}</td>
                                                    <td>{{ $documento->getDatos()['nombreReceptor'] }}</td>
                                                    <td>${{ number_format($documento->getSumPagos(), 2, '.', ',') }}</td>
                                                    <td>{{ $documento->getDatos()['total'] }}</td>
                                                    <td>{{ $documento->getTipo() }}</td>
                                                    <td>{{ $documento->getEstatus() }}</td>
                                                    <td>
                                                        @if ($documento->getEstatus() !== \App\Models\UsersPeriodosDocumentos::PAGADO)
                                                            {!! HTML::link('#', '<i class="icon-cash" aria-hidden="true"></i>', [ 'class' => 'btn btn-default fecha-pagado', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Pagar', 'data-toggle' => 'modal', 'data-target' => '#modal-datos-pagado', 'data-id' => $documento->getId() ]) !!}
                                                        @endif
                                                        {!! HTML::link(action('Users\PeriodosController@getDeleteDocumento', [ 'id' => $documento->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane {{ $tipo === 'RECIBIDO' ? 'active' : '' }}" id="basic-tab4">
                            <h3>EGRESOS</h3>
                            <div class="margin-bottom-50">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>UUID</th>
                                                <th>Fecha Emisión</th>
                                                <th>RFC Emisor</th>
                                                <th>Nombre Emisor</th>
                                                <th>RFC Receptor</th>
                                                <th>Nombre Receptor</th>
                                                <th>Pagado</th>
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        <tbody>
                                            @foreach ($recibidosAnteriores as $documento)
                                                <tr>
                                                    <td>{{ $documento->getDatos()['uuid'] }}</td>
                                                    <td>{{ $documento->getDatos()['fechaEmision'] }}</td>
                                                    <td>{{ $documento->getDatos()['rfcEmisor'] }}</td>
                                                    <td>{{ $documento->getDatos()['nombreEmisor'] }}</td>
                                                    <td>{{ $documento->getDatos()['rfcReceptor'] }}</td>
                                                    <td>{{ $documento->getDatos()['nombreReceptor'] }}</td>
                                                    <td>${{ number_format($documento->getSumPagos(), 2, '.', ',') }}</td>
                                                    <td>{{ $documento->getDatos()['total'] }}</td>
                                                    <td>{{ $documento->getTipo() }}</td>
                                                    <td>{{ $documento->getEstatus() }}</td>
                                                    <td>
                                                        @if ($documento->getEstatus() !== \App\Models\UsersPeriodosDocumentos::PAGADO)
                                                            {!! HTML::link('#', '<i class="icon-cash" aria-hidden="true"></i>', [ 'class' => 'btn btn-default fecha-pagado', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Pagar', 'data-toggle' => 'modal', 'data-target' => '#modal-datos-pagado', 'data-id' => $documento->getId() ]) !!}
                                                        @endif
                                                        {!! HTML::link(action('Users\PeriodosController@getDeleteDocumento', [ 'id' => $documento->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /basic tabs -->
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/periodos_edit.js?v=1.0.0') !!}
@append
