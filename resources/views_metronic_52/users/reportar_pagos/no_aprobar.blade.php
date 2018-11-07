@section('title', 'Agregar Reporte de pago')

@section('content')

    {!! BootForm::open() !!}
        {!! BootForm::textarea('comentariosNoAprobado', 'Comentarios', null, []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection
