
@section('title', 'Editar Datos')

@section('content')

    {!! BootForm::open([ 'files' => true ]) !!}
        {!! BootForm::text('password', 'Password', $infoFactura->getPassword(), []) !!}
        @if (!empty($user->getInfoFactura()) && !empty($user->getInfoFactura()->getDocumentByType('ARCHIVO_CERTIFICADO')))
            {!! Label::success('Archivo de ceritifcado cargado correctamente') !!}
            @if ($user->getInfoFactura()->getDocumentByType('ARCHIVO_CERTIFICADO')->getRevisado())
                {!! Label::success('Revisado') !!}
            @else
                {!! Label::danger('No revisado') !!}
            @endif
            @if ($user->getInfoFactura()->getDocumentByType('ARCHIVO_CERTIFICADO')->getValidado())
                {!! Label::success('Validado correctamente') !!}
            @else
                {!! Label::danger('No validado') !!}
            @endif
            {!! HTML::link(action('Users\AccountsController@getBorrarDocumento', [ 'id' => $user->getInfoFactura()->getDocumentByType('ARCHIVO_CERTIFICADO')->getId() ]), 'Eliminar Documento', [ 'class' => 'btn btn-danger' ]) !!}
            <br />
            <br />
        @else
            {!! BootForm::file('archivoCertificado', 'Archivo de certificado', [ 'accept' => '.cer' ]) !!}
        @endif

        @if (!empty($user->getInfoFactura()) && !empty($user->getInfoFactura()->getDocumentByType('ARCHIVO_LLAVE')))
            {!! Label::success('Archivo de llave cargado correctamente') !!}
            @if ($user->getInfoFactura()->getDocumentByType('ARCHIVO_LLAVE')->getRevisado())
                {!! Label::success('Revisado') !!}
            @else
                {!! Label::danger('No revisado') !!}
            @endif
            @if ($user->getInfoFactura()->getDocumentByType('ARCHIVO_LLAVE')->getValidado())
                {!! Label::success('Validado correctamente') !!}
            @else
                {!! Label::danger('No validado') !!}
            @endif
            {!! HTML::link(action('Users\AccountsController@getBorrarDocumento', [ 'id' => $user->getInfoFactura()->getDocumentByType('ARCHIVO_LLAVE')->getId() ]), 'Eliminar Documento', [ 'class' => 'btn btn-danger' ]) !!}
        @else
            {!! BootForm::file('archivoLlave', 'Archivo de llave', [ 'accept' => '.key' ]) !!}
        @endif
        {!! BootForm::submit('Agregar') !!}
    {!! BootForm::close() !!}

@endsection
