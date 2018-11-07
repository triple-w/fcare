@section('title', 'Propuesta')

@section('content')

    {!! BootForm::open([ 'files' => true ]) !!}
        {!! BootForm::textarea('propuesta', 'Propuesta', null, []) !!}
        {!! BootForm::file('docs[]', 'Documentos', [ 'multiple' => true ]) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection
