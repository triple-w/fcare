@section('title', 'Agregar Cliente')

@section('content')
    
    {!! BootForm::open() !!}
        {!! BootForm::text('rfc', 'RFC', $cliente->getRfc(), []) !!}
        {!! BootForm::text('razonSocial', 'Razon Social', $cliente->getRazonSocial(), []) !!}
        {!! BootForm::text('calle', 'Calle', $cliente->getCalle(), []) !!}
        {!! BootForm::text('noExt', 'Numero Exterior', $cliente->getNoExt(), []) !!}
        {!! BootForm::text('noInt', 'Numero Interior', $cliente->getNoInt(), []) !!}
        {!! BootForm::text('colonia', 'Colonia', $cliente->getColonia(), []) !!}
        {!! BootForm::text('municipio', 'Municipio', $cliente->getMunicipio(), []) !!}
        {!! BootForm::text('localidad', 'Localidad', $cliente->getLocalidad(), []) !!}
        {!! BootForm::text('estado', 'Estado', $cliente->getEstado(), []) !!}
        {!! BootForm::text('codigoPostal', 'Codigo Postal', $cliente->getCodigoPostal(), []) !!}
        {!! BootForm::text('pais', 'Pais', $cliente->getPais(), []) !!}
        {!! BootForm::text('telefono', 'Telefono', $cliente->getTelefono(), []) !!}
        {!! BootForm::text('nombreContacto', 'Nombre de Contacto', $cliente->getNombreContacto(), []) !!}
        {!! BootForm::text('email', 'Email', $cliente->getEmail(), []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection