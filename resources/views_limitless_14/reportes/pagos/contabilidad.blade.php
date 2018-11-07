
@section('title', 'Pagos de Contabilidad')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" data-model="App\Models\Users" datatable >
                <thead>
                    <tr>
                        <th>Transaccion</th>
                        <th>Plan</th>
                        <th>Monto</th>
                        <th>Fecha de Pago</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>{{ $pago->getIdTransaccion() }}</td>
                            <td>{{ $pago->getTipoPlan() }}</td>
                            <td>{{ $pago->getPrecio() }}</td>
                            <td>{{ $pago->getFechaPago()->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $pago->getUser()->getUsername() }}</td>
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
