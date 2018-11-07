
@section('title', 'Impuestos')

@section('content')

    {!! HTML::link(action('Users\ImpuestosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Impuesto', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tasa</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($impuestos as $impuesto)
                        <tr>
                            <td>{{ $impuesto->getNombre() }}</td>
                            <td>{{ $impuesto->getTasa() }}</td>
                            <td>{{ $impuesto->getTipo() }}</td>
                            <td>
                                {!! HTML::link(action('Users\ImpuestosController@getEdit', [ 'id' => $impuesto->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                                {!! HTML::link(action('Users\ImpuestosController@getDelete', [ 'id' => $impuesto->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/generals.js') !!}
@append
