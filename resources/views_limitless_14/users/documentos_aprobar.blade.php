
@section('title', 'Aprobar Documentos')

@section('content')

    <table class="table" datatable>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Tipo documento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentos as $documento)
                <tr>
                    <td>{{ $documento->getFacturaInfo()->getUser()->getUsername() }}</td>
                    <td>{{ $documento->getTipo() === \App\Models\UsersInfoFacturaDocumentos::LLAVE ? $documento->getFacturaInfo()->getPassword() : '' }}</td>
                    <td>{{ $documento->getTipo() }}</td>
                    <td>
                        {!! HTML::link(asset("/uploads/users_documentos/{$documento->getName()}"), 'Descargar', [ 'class' => 'btn btn-info' ]) !!}
                        {!! HTML::link(action('Users\AccountsController@getAprobarDocumento', [ 'id' => $documento->getId() ]), 'Aprobar y Cambiar', [ 'class' => 'btn btn-success' ]) !!}
                        {!! HTML::link(action('Users\AccountsController@getNoAprobarDocumento', [ 'id' => $documento->getId() ]), 'No Aprobar', [ 'class' => 'btn btn-danger' ]) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append