@section('title', 'Reportar Pagos')

@section('content')

    {!! HTML::link(action('Users\ReportarPagosController@getAdd'), '<i class="icon-plus2" aria-hidden="true"></i> Nuevo Reporte de Pago', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <h3>
        <p class="text-center">Información de Cuentas de Pago</p>
    </h3>
    <p class="text-center">Nombre: </p>
    <p class="text-center">Cuenta: </p>
    <p class="text-center">Clabe: </p>
    <p class="text-center">Banco: </p>

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Revisado</th>
                        <th>Aprobado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>{{ $pago->getFecha()->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $pago->getCantidad() }}</td>
                            <td>
                                @if ($pago->getRevisado())
                                    {!! Label::success('Revisado') !!}
                                @else
                                    {!! Label::danger('No Revisado') !!}
                                @endif
                            </td>
                            <td>
                                @if ($pago->getAprobado())
                                    {!! Label::success('Aprobado') !!}
                                @else
                                    {!! Label::danger('No Aprobado') !!}
                                @endif
                            </td>
                            <td>{{ $pago->getObservaciones() }}</td>
                            <td>
                                {!! HTML::link(action('Users\ReportarPagosController@getView', [ 'id' => $pago->getid() ]), '<i class="icon-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Ver' ]) !!}
                                @if (($pago->getRevisado() && !$pago->getAProbado()) || !$pago->getRevisado())
                                    {!! HTML::link(action('Users\ReportarPagosController@getEdit', [ 'id' => $pago->getid() ]), '<i class="icon-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                                @endif
                                @if (!$pago->getRevisado())
                                    {!! HTML::link(action('Users\ReportarPagosController@getDelete', [ 'id' => $pago->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/generals.js') !!}
@append
