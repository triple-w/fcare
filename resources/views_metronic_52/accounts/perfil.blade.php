
@section('title', 'Editar Perfil')

@section('content')

    {!! BootForm::open([ 'id' => 'form-perfil', 'files' => true ]) !!}
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
        {!! BootForm::select('numeroRegimen', 'Regimen Fiscal', \App\Models\UsersPerfil::getRegimenes(), $perfil->getNumeroRegimen(), []) !!}
        <div style="max-width: 400px">
        @if (!empty($user->getLogo()))
            {!! HTML::image("uploads/users_logos/{$user->getLogo()->getName()}", 'Logo', [ 'class' => 'img img-responsive' ]) !!}
            {!! HTML::link(action('Users\AccountsController@getBorrarLogo', [ 'id' => $user->getLogo()->getId() ]), 'Eliminar Imagen', [ 'class' => 'btn btn-danger' ]) !!}
        @else
            <div class="row">
                <div class="col-md-6">
                    <img class="show-image" src="" class="img img-responsive">
                </div>
            </div>
            <input type="hidden" name="thumbnail" class="image-thumbnail" value="">
            {!! BootForm::file('imagen', 'Logo', [ 'class' => 'imagen-logo' ]) !!}
        @endif
        </div><br />
            <br />
        {!! BootForm::submit('Agregar') !!}
    {!! BootForm::close() !!}

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
