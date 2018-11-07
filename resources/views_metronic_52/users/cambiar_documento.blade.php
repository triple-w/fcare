
@section('title', 'Cambiar documento')

@section('content')

    {!! BootForm::open([ 'files' => true ]) !!}
        {!! BootForm::file('archivo', 'Archivo', [ 'required' => 'required', 'accept' => '.pem' ]) !!}
        {!! BootForm::submit('Agregar') !!}
    {!! BootForm::close() !!}

@endsection