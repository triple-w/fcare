
@section('title', 'Planes vencidos')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Plan</th>
                        <th>Estatus</th>
                        <th>Fecha Vencimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @if ($user->getRol() !== 'ROLE_ADMIN')
                            @set('pago', \App\Models\UsersPagosContabilidad::getUltimoPago($user))
                            @if (!empty($pago) && $pago->getDescargasDisponibles() <= 0)
                                <tr>
                                    <td>{{ $pago->getUser()->getUsername() }}</td>
                                    <td>{{ $pago->getTipoPlan() }}</td>
                                    <td>
                                        @set('now', \Carbon\Carbon::now())
                                        @set('fechaPago', $pago->getFechaPago())
                                        @set('diff', $now->diffInMonths($pago->getFechaPago()))
                                        @if ($pago->getTipoPlan() === '1_MESES' && $diff >= 1)
                                            {!! Label::danger('Vencido') !!}
                                        @elseif ($pago->getTipoPlan() === '3_MESES' && $diff >= 3)
                                            {!! Label::danger('Vencido') !!}
                                        @elseif ($pago->getTipoPlan() === '6_MESES' && $diff >= 6)
                                            {!! Label::danger('Vencido') !!}
                                        @elseif ($pago->getTipoPlan() === '12_MESES' && $diff >= 12)
                                            {!! Label::danger('Vencido') !!}
                                        @else
                                            {!! Label::info('Por vencer') !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pago->getTipoPlan() === '1_MESES')
                                            {{ $pago->getFechaPago()->addMonths(1) }}
                                        @elseif ($pago->getTipoPlan() === '3_MESES')
                                            {{ $pago->getFechaPago()->addMonths(3) }}
                                        @elseif ($pago->getTipoPlan() === '6_MESES')
                                            {{ $pago->getFechaPago()->addMonths(6) }}
                                        @elseif ($pago->getTipoPlan() === '12_MESES')
                                            {{ $pago->getFechaPago()->addMonths(12) }}
                                        @else
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
