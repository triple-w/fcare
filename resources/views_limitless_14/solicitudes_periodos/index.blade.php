
@section('title', 'Ver Solicitudes')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Fecha de Solicitud</th>
                        <th>Meses Anteriores</th>
                        <th>Periodos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudesPeriodos as $solicitudPeriodo)
                        <tr>
                            <td>{{ $solicitudPeriodo->getFechaSolicitud()->format('Y-m-d') }}</td>
                            <td>{{ $solicitudPeriodo->getMeses() }}</td>
                            <td>
                                @if (!empty($solicitudPeriodo->getmesesSolicitud()))
                                    @foreach ($solicitudPeriodo->getMesesSolicitud() as $key => $mes)
                                        {{ $mes }} - {{ $solicitudPeriodo->getAniosSolicitud()[$key] }} <br />
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                {!! HTML::link(action('SolicitudesPeriodos\SolicitudesPeriodosController@getSolicitudRevisada', [ 'id' => $solicitudPeriodo->getId() ]), 'Revisada', [ 'class' => 'btn btn-success' ]) !!}
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
