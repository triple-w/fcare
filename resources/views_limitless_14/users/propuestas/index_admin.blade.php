
@section('title', 'Propuestas')

@section('content')

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($propuestas as $propuesta)
                        <tr>
                            <td>{{ $propuesta->getMes() }} - {{ $propuesta->getAnio() }}</td>
                            <td>
                                {!! HTML::link(action('Users\PeriodosMovimientosPropuestasController@getViewAdmin', [ 'id' => $propuesta->getid() ]), '<i class="icon-eye" aria-hidden="true"></i>', [ 'class' => 'btn btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Ver' ]) !!}
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
