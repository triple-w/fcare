@section('title', 'Agregar Impuesto')

@section('content')
    
    {!! BootForm::open() !!}
        {!! BootForm::text('nombre', 'Nombre', null, []) !!}
        {!! BootForm::text('tasa', 'Tasa %', null, [ 'class' => 'fixed-to-2' ]) !!}
        {!! BootForm::select('tipo', 'Tipo', [ 'TRASLADO' => 'Traslado', 'RETENCION' => 'Retención' ], [], []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection