
@section('title', 'Ver Periodos')

@section('content')

    {!! HTML::link(action('Users\PeriodosController@getAdd', [ 'id' => $user->getId() ]), '<i class="icon-plus2" aria-hidden="true"></i> Nuevo Periodo', [ 'class' => 'btn btn-default' ]) !!}

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periodos as $periodo)
                        <tr>
                            <td>{{ $periodo->getMes() }} - {{ $periodo->getAnio() }}</td>
                            <td>{{ $periodo->getEstatus() }}</td>
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
