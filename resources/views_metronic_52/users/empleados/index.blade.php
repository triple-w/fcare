
@section('title', 'Empleados')

@section('content')

    {!! HTML::link(action('Users\EmpleadosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Empleado', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>RFC</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            <td>{{ $empleado->getRfc() }}</td>
                            <td>{{ $empleado->getNombre() }}</td>
                            <td>{{ $empleado->getEmail() }}</td>
                            <td>
                                {!! HTML::link(action('Users\EmpleadosController@getEdit', [ 'id' => $empleado->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]) !!}
                                {!! HTML::link(action('Users\EmpleadosController@getDelete', [ 'id' => $empleado->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]) !!}
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
