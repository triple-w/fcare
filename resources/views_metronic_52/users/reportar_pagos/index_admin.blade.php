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
                        <th>Revisado</th>
                        <th>Aprobado</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                    @if($pago->getUser()->getAdmin() == Auth::user()->getId() || Auth::user()->getId() == 1)
                        <tr>
                            <td>{{ $pago->getId() }}</td>
                            <td>{{ $pago->getFecha()->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $pago->getUser()->getUsername() }}</td>
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
                            <td>{{ $pago->getCantidad() }}</td>
                            <td>
                                {!! HTML::link(action('ReportarPagos\ReportarPagosController@getView', [ 'id' => $pago->getid() ]), '<i class="icmn-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Ver' ]) !!}
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
