
@section('title', 'Agregar Timbres')

@section('content')

    {!! BootForm::open(); !!}
        {!! BootForm::text('numeroTimbres', 'Numero de timbres', null, []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection