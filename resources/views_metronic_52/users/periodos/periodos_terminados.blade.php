
@section('title', 'Ver Periodos')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Propuesta Enviada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periodosTerminados as $periodoTerminado)
                        <tr>
                            <td>{{ $periodoTerminado->getMes() }} - {{ $periodoTerminado->getAnio() }}</td>
                            <td>
                                @if ($periodoTerminado->getRevisado())
                                    {!! Label::success('Si') !!}
                                @else
                                    {!! Label::info('No') !!}
                                @endif
                            </td>
                            <td>
                                @if (!$periodoTerminado->getRevisado())
                                    {!! HTML::link(action('Users\PeriodosMovimientosPropuestasController@getAdd', [ 'id' => $user->getId(), 'mes' => $periodoTerminado->getMes(), 'anio' => $periodoTerminado->getAnio(), 'idTerminado' => $periodoTerminado->getId() ]), 'Nueva Propuesta', [ 'class' => 'btn btn-default' ]) !!}
                                @endif
                                {!! HTML::link(action('Users\PeriodosMovimientosController@getDownloadZip', [ 'mes' => $periodoTerminado->getMes(), 'anio' => $periodoTerminado->getAnio(), 'idUser' => $user->getId() ]), 'Descargar ZIP', [ 'class' => 'btn btn-success' ]) !!}
                                {!! HTML::link(action('Users\PeriodosMovimientosController@getMovimientos', [ 'id' => $user->getId(), 'mes' => $periodoTerminado->getMes(), 'anio' => $periodoTerminado->getAnio() ]), 'Movimientos', ['class' => 'btn btn-default' ]) !!}
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
