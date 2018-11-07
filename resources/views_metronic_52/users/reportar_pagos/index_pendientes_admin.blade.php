@section('title', 'Reportar Pagos')

@section('content')

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>{{ $pago->getId() }}</td>
                            <td>{{ $pago->getFecha()->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $pago->getUser()->getUsername() }}</td>
                            <td>{{ $pago->getCantidad() }}</td>
                            <td>
                                {!! HTML::link(action('ReportarPagos\ReportarPagosController@getView', [ 'id' => $pago->getid() ]), '<i class="icmn-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Ver' ]) !!}
                                {!! HTML::link(action('ReportarPagos\ReportarPagosController@getAprobarPago', [ 'id' => $pago->getid() ]), '<i class="icmn-file-check2" aria-hidden="true"></i>', [ 'class' => 'btn btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Aprobar' ]) !!}
                                {!! HTML::link(action('ReportarPagos\ReportarPagosController@getNoAprobarPago', [ 'id' => $pago->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'No Aprobar' ]) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
