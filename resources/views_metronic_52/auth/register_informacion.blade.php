
@section('title', 'Editar Perfil')

@section('class_body', 'login-container')
@set('background', asset('webroot/img/accounting_background.jpg'))
@section('style_body', "background-image: url('{$background}'); background-position: center;")

@section('content')

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">
                    <div class="well">
                        <ul id="stepy-004826721065003481-header" class="stepy-header">
                            <li id="stepy-004826721065003481-head-0" style="cursor: default;">
                                <div>1</div><span>Datos de usuario</span></li><li id="stepy-004826721065003481-head-0" style="cursor: default;">
                            </li>
                            <li id="stepy-004826721065003481-head-1" class="stepy-active" style="cursor: default;">
                                <div>2</div><span>Datos de Perfil</span></li><li id="stepy-004826721065003481-head-1" style="cursor: default;">
                            </li>
                            <li id="stepy-004826721065003481-head-2" style="cursor: default;">
                                <div>3</div><span>Datos de Pago</span></li><li id="stepy-004826721065003481-head-2" style="cursor: default;">
                            </li>
                        </ul>
                    </div>
                    <br />
                    <br />
                    <br />
                    <div class="panel panel-body">
                        <div class="text-center">
                            <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                            <h5 class="content-group">Información para facturar</h5>
                        </div>
                    {!! BootForm::open([ 'id' => 'form-perfil', 'files' => true, 'url' => action('Users\AccountsController@postRegisterInformacion', [ 'id' => $user->getId() ]) ]) !!}
                        {!! BootForm::text('rfc', 'RFC', $perfil->getRfc(), []) !!}
                        {!! BootForm::text('razonSocial', 'Razon Social', $perfil->getRazonSocial(), []) !!}
                        {!! BootForm::text('calle', 'Calle', $perfil->getCalle(), []) !!}
                        {!! BootForm::text('noExt', 'Numero Exterior', $perfil->getNoExt(), []) !!}
                        {!! BootForm::text('noInt', 'Numero Interior', $perfil->getNoInt(), []) !!}
                        {!! BootForm::text('colonia', 'Colonia', $perfil->getColonia(), []) !!}
                        {!! BootForm::text('municipio', 'Municipio', $perfil->getMunicipio(), []) !!}
                        {!! BootForm::text('localidad', 'Localidad', $perfil->getLocalidad(), []) !!}
                        {!! BootForm::text('estado', 'Estado', $perfil->getEstado(), []) !!}
                        {!! BootForm::text('codigoPostal', 'Codigo Postal', $perfil->getCodigoPostal(), []) !!}
                        {!! BootForm::text('pais', 'Pais', $perfil->getPais(), []) !!}
                        {!! BootForm::text('telefono', 'Telefono', $perfil->getTelefono(), []) !!}
                        {!! BootForm::text('nombreContacto', 'Nombre de Contacto', $perfil->getNombreContacto(), []) !!}
                        {!! BootForm::text('ciec', 'CIEC', $perfil->getCiec(), []) !!}
                        {!! BootForm::select('numeroRegimen', 'Regimen Fiscal', \App\Models\UsersPerfil::getRegimenes(), $perfil->getNumeroRegimen(), []) !!}
                        @if (!empty($user->getLogo()))
                            {!! HTML::image("uploads/users_logos/thumbnails/{$user->getLogo()->getName()}", 'Logo', [ 'class' => 'img img-responsive' ]) !!}
                            {!! HTML::link(action('Users\AccountsController@getBorrarLogo', [ 'id' => $user->getLogo()->getId() ]), 'Eliminar Imagen', [ 'class' => 'btn btn-danger' ]) !!}
                            <br />
                            <br />
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="show-image" src="" class="img img-responsive">
                                </div>
                            </div>
                            <input type="hidden" name="thumbnail" class="image-thumbnail" value="">
                            {!! BootForm::file('imagen', 'Logo', [ 'class' => 'imagen-logo' ]) !!}
                        @endif
                        {!! BootForm::submit('Agregar') !!}
                    {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/libs/cropper/dist/cropper.js') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/perfil.js') !!}
@append

@section('styles')
    <style>
        .show-image {
            width:100%
        }
    </style>
    {!! HTML::styleLocal('webroot/libs/cropper/dist/cropper.css') !!}
@append
