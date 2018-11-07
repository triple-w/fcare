
@section('title', 'Productos')

@section('content')

    {!! HTML::link(action('Users\ProductosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Producto', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->getClave() }}</td>
                            <td>{{ $producto->getDescripcion() }}</td>
                            <td>{{ $producto->getPrecio() }}</td>
                            <td>
                                {!! HTML::link(action('Users\ProductosController@getEdit', [ 'id' => $producto->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                                {!! HTML::link(action('Users\ProductosController@getDelete', [ 'id' => $producto->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
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
