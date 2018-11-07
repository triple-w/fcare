@section('title', 'Agregar Reporte de pago')

@section('content')

    {!! BootForm::open([ 'files' => true, 'method' => 'POST' ]) !!}
        {!! BootForm::text('cantidad', 'Cantidad', null, []) !!}
        {!! BootForm::textarea('observaciones', 'Observaciones', null, []) !!}
        {!! BootForm::file('images[]', 'Imagenes', [ 'id' => 'imagenes', 'accept' => '.png,.jpg,.jpeg,.gif,.bmp', 'multiple' => 'multiple' ]); !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection
