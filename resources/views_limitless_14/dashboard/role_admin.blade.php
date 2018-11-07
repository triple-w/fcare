
@section('title', 'Home')

@section('content')

    <h2>Transferencias</h2>
    @set('transferencias', \App\Models\TimbresMovs::findBy([ 'tipo' => \App\Models\TimbresMovs::TRANSFERENCIA ]))
    <table class="table datatable-pagination" datatable>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Timbres</th>
                <th>Fecha</th>
                <th>Pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transferencias as $transferencia)
                <tr>
                    <td>{{ $transferencia->getUserTransferencia()->getUsername() }}</td>
                    <td>{{ $transferencia->getNumeroTimbres() }}</td>
                    <td>{{ $transferencia->getFecha()->format('Y-m-d H:i:s') }}</td>
                    <td>
                        {{ empty($transferencia->getPago()) ? 'Sin Pago' : "ID Transaccion - " . $transferencia->getPago()->getIdTransaccion() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Timbres por usuario</h2>
    @set('users', \App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO' ]))
    <table class="table datatable-pagination" datatable>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Timbres</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->getUsername() }}</td>
                    <td>{{ $user->getTimbresDisponibles() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append