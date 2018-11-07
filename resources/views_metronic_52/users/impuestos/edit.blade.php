@section('title', 'Editar Impuesto')

@section('content')
    
    {!! BootForm::open() !!}
        {!! BootForm::text('nombre', 'Nombre', $impuesto->getNombre(), []) !!}
        {!! BootForm::text('tasa', 'Tasa', $impuesto->getTasa(), [ 'class' => 'fixed-to-2' ]) !!}
        {!! BootForm::select('tipo', 'Tipo', [ 'TRASLADO' => 'Traslado', 'RETENCION' => 'Retención' ], $impuesto->getTipo(), []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection