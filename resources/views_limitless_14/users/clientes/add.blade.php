@section('title', 'Agregar Cliente')

@section('content')

    {!! BootForm::open() !!}
        {!! BootForm::text('rfc', 'RFC', null, []) !!}
        {!! BootForm::text('razonSocial', 'Razon Social', null, []) !!}
        {!! BootForm::text('calle', 'Calle', null, []) !!}
        {!! BootForm::text('noExt', 'Numero Exterior', null, []) !!}
        {!! BootForm::text('noInt', 'Numero Interior', null, []) !!}
        {!! BootForm::text('colonia', 'Colonia', null, []) !!}
        {!! BootForm::text('municipio', 'Municipio', null, []) !!}
        {!! BootForm::text('localidad', 'Localidad', null, []) !!}
        {!! BootForm::text('estado', 'Estado', null, []) !!}
        {!! BootForm::text('codigoPostal', 'Codigo Postal', null, []) !!}
        {!! BootForm::text('pais', 'Pais', null, []) !!}
        {!! BootForm::text('telefono', 'Telefono', null, []) !!}
        {!! BootForm::text('nombreContacto', 'Nombre de Contacto', null, []) !!}
        {!! BootForm::text('email', 'Email', null, []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection
