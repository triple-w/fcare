
@section('title', 'Clientes')

@section('content')

    {!! HTML::link(action('Users\ClientesController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Cliente', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>RFC</th>
                        <th>Razon social</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->getRfc() }}</td>
                            <td>{{ $cliente->getRazonSocial() }}</td>
                            <td>{{ $cliente->getEmail() }}</td>
                            <td>
                                {!! HTML::link(action('Users\ClientesController@getEdit', [ 'id' => $cliente->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                                {!! HTML::link(action('Users\ClientesController@getDelete', [ 'id' => $cliente->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
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
