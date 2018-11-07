
@section('title', 'Usuarios')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" data-model="App\Models\Users" datatable >
                <thead>
                    <tr>
                        <th data-name="email">Email</th>
                        <th data-name="email">RFC</th>
                        <th data-name="rol">Rol</th>
                        <th data-name="verified">Verificado</th>
                        <th data-name="active">Activo</th>
                        <th data-name="lastLogin">Last Login</th>
                        <th data-name="id">Fecha de Vencimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @set('ultimoPago', \App\Models\UsersPagosContabilidad::getUltimoPago($user))
                        @if ($user->getRol() !== 'ROLE_ADMIN')
                            @if (empty($ultimoPago) || (!empty($ultimoPago) && $ultimoPago->getDescargasDisponibles() <= 0))
                                <tr>
                                    <td>{{ $user->getEmail() }}</td>
                                    <td>{{ $user->getUsername() }}</td>
                                    <td>{{ $user->getRol() }}</td>
                                    <td>
                                    @if ($user->getVerified())
                                        {!! Label::success('Verificado') !!}
                                    @else
                                        {!! Label::danger('No verificado') !!}
                                    @endif
                                    </td>
                                    <td>
                                    @if ($user->getActive())
                                        {!! Label::success('Activo') !!}
                                    @else
                                        {!! Label::danger('No activo') !!}
                                    @endif
                                    </td>
                                    <td>{{ $user->getLastLogin() }}</td>
                                    <td>
                                        @if (!empty($ultimoPago))
                                            @if ($ultimoPago->getTipoPlan() === '1_MESES')
                                                {{ $ultimoPago->getFechaPago()->addMonths(1) }}
                                            @elseif ($ultimoPago->getTipoPlan() === '3_MESES')
                                                {{ $ultimoPago->getFechaPago()->addMonths(3) }}
                                            @elseif ($ultimoPago->getTipoPlan() === '6_MESES')
                                                {{ $ultimoPago->getFechaPago()->addMonths(6) }}
                                            @elseif ($ultimoPago->getTipoPlan() === '12_MESES')
                                                {{ $ultimoPago->getFechaPago()->addMonths(12) }}
                                            @else
                                            @endif
                                        @else
                                            {!! Label::info('Sin pago aun') !!}
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
