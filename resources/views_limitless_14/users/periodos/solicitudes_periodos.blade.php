
@section('title', 'Ver Periodos')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Fecha de Solicitud</th>
                        <th>Meses Anteriores</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudesPeriodos as $solicitudPeriodo)
                        <tr>
                            <td>{{ $solicitudPeriodo->getFechaSolicitud()->format('Y-m-d') }}</td>
                            <td>{{ $solicitudPeriodo->getMeses() }}</td>
                            <td>
                                {!! HTML::link(action('Users\AccountsController@getSolicitudRevisada', [ 'id' => $solicitudPeriodo->getId() ]), 'Revisada', [ 'class' => 'btn btn-success' ]) !!}
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
