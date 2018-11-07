
@section('title', 'Documentos de usuario')

@section('content')

    <table class="table" datatable>
        <thead>
            <tr>
                <th>Contraseña</th>
                <th>Tipo documento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentos as $documento)
                <tr>
                    <td>{{ $documento->getTipo() === \App\Models\UsersInfoFacturaDocumentos::LLAVE ? $documento->getFacturaInfo()->getPassword() : '' }}</td>
                    <td>{{ $documento->getTipo() }}</td>
                    <td>
                        {!! HTML::link(asset("/uploads/users_documentos/{$documento->getName()}"), 'Descargar', [ 'class' => 'btn btn-info' ]) !!}
                        {!! HTML::link(action('Users\AccountsController@getCambiarDocumento', [ 'id' => $documento->getId() ]), 'Cambiar', [ 'class' => 'btn btn-success' ]) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/generals.js') !!}
@append
