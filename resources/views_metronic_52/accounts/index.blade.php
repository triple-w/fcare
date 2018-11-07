
@section('title', 'Usuarios')

@section('content')
    @if(Auth::user()->getId() == 1)
    {!! HTML::link(action('Users\AccountsController@getAdd'), 'Agregar', [ 'class' => 'btn btn-default', 'icon' => 'plus-circle' ]) !!}
    @endif
    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable >
                <thead>
                    <tr>
                        <th>Nombre contacto</th>
                        <th>RFC</th>
                        <th>Email</th>
                        <th>Razón social</th>
                        <th>Teléfono</th>
                        <th>Último Login</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <?php $perfil = $user->getPerfil() ?>
                        <tr>
                            <td>{{ $perfil->getNombreContacto() }}</td>
                            <td>{{ $user->getUsername() }}</td>
                            <td>{{ $user->getEmail() }}</td>
                            <td>{{ $perfil->getRazonSocial() }}</td>
                            <td>{{ $perfil->getTelefono() }}</td>
                            <td>{{ $user->getLastLogin() }}</td>
                            <td>
                                {!! HTML::link(action('Users\AccountsController@getEdit', [ 'id' => $user->getId() ]), 'Ver más', ['class' => 'btn btn-default' ]) !!}
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