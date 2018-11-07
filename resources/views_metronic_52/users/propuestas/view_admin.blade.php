@section('title', 'Ver Declaracion')

@section('content')

    <div class="well">
        {{ $propuesta->getPropuesta() }}
    </div>
    <br />
    <br />
    @foreach ($propuesta->getDocumentos() as $documento)
        {!! HTML::link("uploads/propuestas_documentos/{$documento->getName()}", 'Descargar Documento', []) !!}<br />
    @endforeach

@endsection
