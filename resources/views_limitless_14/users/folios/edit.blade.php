@section('title', 'Editar Impuesto')

@section('content')
    
    {!! BootForm::open() !!}
        {!! BootForm::text('serie', 'Serie', $folio->getSerie(), []) !!}
        {!! BootForm::text('folio', 'Folio', $folio->getFolio(), []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection