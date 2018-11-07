@section('title', 'Agregar Impuesto')

@section('content')

    {!! BootForm::open() !!}
        {!! BootForm::select('tipo', 'Tipo', \App\Models\Folios::getDiffFolios(Auth::user(), \App\Models\Folios::getTiposFolio()), null, []) !!}
        {!! BootForm::text('serie', 'Serie', null, []) !!}
        {!! BootForm::text('folio', 'Folio', null, []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection
