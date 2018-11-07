@section('title', 'Quejas y Sugerencias')

@section('content')

    <h3>Ayudanos a mejorar</h3>
    {!! BootForm::open() !!}
        {!! BootForm::textarea('queja', '¿Qué te gustaría eliminar o complementar a la plataforma?', null, []) !!}
        {!! BootForm::submit('Enviar') !!}
    {!! BootForm::close() !!}

@endsection
