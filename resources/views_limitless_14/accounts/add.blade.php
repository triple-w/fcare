@section('title', 'Editar Usuario')

@section('content')

<div id="modal-borrar-user" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Usuario</h4>
            </div>
            <div class="modal-body">
            <p>¿Estás seguro de eliminar el usuario <strong> {{ $user->getUsername() }} </strong>? Esta operación <strong>NO</strong> se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                {!! HTML::link(action('Users\AccountsController@getBorrarUsuario', [ 'id' => $user->getId() ]), 'Eliminar', ['class' => 'btn btn-danger' ]) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    {!! HTML::link(action('Users\AccountsController@getIndex'), 'Regresar', [ 'class' => 'btn btn-default', 'icon' => 'arrow-left' ]) !!}

    {!! BootForm::open(); !!}

        {{-- FIX Check When Action is Edit --}}
        @if (empty($user->getId()))
            {!! BootForm::email('email', 'Email', $user->getEmail(), ['required' => 'required']); !!}
            {!! BootForm::text('username', 'Username', $user->getUsername(), ['required' => 'required']); !!}
        @endif

        {{-- FIX Check When Action is Edit --}}
        @if (empty($user->getId()))
            {!! BootForm::password('password', 'Password', ['required' => 'required']); !!}
            {!! BootForm::password('password_confirmation', 'Password Confirm', ['required' => 'required']); !!}
        @else
        <div class="row">
            <h2>Usuario</h2>
            <?php $perfil = $user->getPerfil() ?>
            <div class="col-md-4">
                <p><strong>Usuario:</strong> {{ $user->getUsername() }}</p>
                <p><strong>Email: </strong> {{ $user->getEmail() }} - <a href="mailto: {{ $user->getEmail() }}">Escribir email</a></p>
            </div>
            <div class="col-md-4">
                <p><strong>Rol: </strong> {{ $user->getRol() }}</p>
                @if ($user->getVerified())
                    {!! Label::success('Verificado') !!}
                @else
                    {!! Label::danger('No verificado') !!}
                @endif
                @if ($user->getActive())
                    {!! Label::success('Activo') !!}
                @else
                    {!! Label::danger('No activo') !!}
                @endif
            </div>
            <div class="col-md-4">
                <p><strong>Último inicio de sesión: </strong> {{ $user->getLastLogin() }}</p>
            </div>
        </div>
        @endif
        @if ($user->getRol() !== 'ROLE_USUARIO' && Auth::user()->getUsername() === 'admin')
            {!! BootForm::checkboxes('permisos[]', 'Permisos', \App\Models\Users::getListPermisos(), $user->getPermisos(), []) !!}
        @endif

        {!! BootForm::checkbox('active', 'Activo', '1', $user->getActive()); !!}
        {!! BootForm::submit('Guardar'); !!}
    {!! BootForm::close(); !!}

    <div class="row">
        <h2>Detalles</h2>
        <div class="col-md-4">
            <p><strong>RFC: </strong> {{ $perfil->getRfc() }}</p>
            <p><strong>Razón social: </strong> {{ $perfil->getRazonSocial() }}</p>
            <p><strong>Calle: </strong> {{ $perfil->getCalle() }}</p>
            <p><strong>Número exterior: </strong> {{ $perfil->getNoExt() }}</p>
            <p><strong>Número interior: </strong> {{ $perfil->getNoInt() }}</p>
        </div>
        <div class="col-md-4">
            <p><strong>Colonia: </strong> {{ $perfil->getColonia() }}</p>
            <p><strong>Municipio: </strong> {{ $perfil->getMunicipio() }}</p>
            <p><strong>Localidad: </strong> {{ $perfil->getLocalidad() }}</p>
            <p><strong>Estado: </strong> {{ $perfil->getEstado() }}</p>
            <p><strong>Código postal: </strong> {{ $perfil->getCodigoPostal() }}</p>
        </div>
        <div class="col-md-4">
            <p><strong>País: </strong> {{ $perfil->getPais() }}</p>
            <p><strong>Teléfono: </strong> {{ $perfil->getTelefono() }}
                @if (!empty($perfil->getTelefono()))
                 - <a href="tel: {{ $perfil->getTelefono() }}">Llamar</a>
                @endif
                </p>
            <p><strong>Nombre de contacto: </strong> {{ $perfil->getNombreContacto() }}</p>
            <p><strong>CIEC: </strong> {{ $perfil->getCiec() }}</p>
            <p><strong>Régimen: </strong> {{ $perfil->getNombreRegimen() }}</p>
        </div>
    </div>
    <br>

    @if ($user->getRol() === 'ROLE_USUARIO')
        <div class="row" id="usersAcciones">
            <h2>Acciones</h2>
            @if (!empty($user->getInfoFactura()))
                <div class="col-sm-2">
                    {!! HTML::link(action('Users\AccountsController@getDocumentos', [ 'id' => $user->getId() ]), 'Documentos', ['class' => 'btn btn-default' ]) !!}
                </div>
            @endif
            <div class="col-sm-2">
                {!! HTML::link(action('Users\AccountsController@getPeriodos', [ 'id' => $user->getId() ]), 'Periodos', ['class' => 'btn btn-default' ]) !!}
            </div>
            <div class="col-sm-2">
                {!! HTML::link(action('Users\AccountsController@getPeriodosTerminados', [ 'id' => $user->getId() ]), 'Periodos Terminados', ['class' => 'btn btn-default' ]) !!}
            </div>
            <div class="col-sm-2">
                {!! HTML::link(action('Users\AccountsController@getSolicitudesPeriodos', [ 'id' => $user->getId() ]), 'Solicitudes Periodos', ['class' => 'btn btn-default' ]) !!}
            </div>
            <div class="col-sm-2">
                {!! HTML::link(action('Users\PeriodosMovimientosController@getBusquedaAdmin', [ 'id' => $user->getId() ]), 'Movimientos', ['class' => 'btn btn-default' ]) !!}
            </div>
            <div class="col-sm-2">
                {!! HTML::link(action('Users\PeriodosMovimientosPropuestasController@getIndexAdmin', [ 'id' => $user->getId() ]), 'Declaraciones', ['class' => 'btn btn-default' ]) !!}
            </div>
            @if (!$user->getVerified())
                <div class="col-sm-2">
                    {!! HTML::link(action('Users\AccountsController@getVerificate', [ 'id' => $user->getId() ]), 'Verificar', ['class' => 'btn btn-default' ]) !!}
                    {!! HTML::link(action('Users\AccountsController@getForwardEmail', [ 'id' => $user->getId() ]), 'Reenvio de correo', ['class' => 'btn btn-default' ]) !!}
                </div>
            @endif
            <div class="col-sm-2">
                <a href="#" id="btn-borrar-user" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    @endif

    <script>
        $('#btn-borrar-user').click(function(e){
            e.preventDefault();
            $('#modal-borrar-user').modal('show');
        });
    </script>

@endsection