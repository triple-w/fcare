@section('title', 'Ver Reporte de pago')

@section('content')

    <h3>cantidad</h3>
    <p>{{ $pago->getCantidad() }}</p>

    <h3>Fecha</h3>
    <p>{{ $pago->getFecha()->format('Y-m-d H:i:s') }}</p>

    <h3>Observaciones</h3>
    <p>{{ $pago->getObservaciones() }}</p>

    @if (!$pago->getAprobado())
        <h3>Comentarios no Aprobado</h3>
        <p>{{ $pago->getComentariosNoAprobado() }}</p>
    @endif

    @foreach ($pago->getImagenes() as $image)
        {!!  HTML::link(asset("uploads/users_reportar_pagos/{$image->getName()}"), HTML::image("uploads/users_reportar_pagos/{$image->getName()}", '', [ 'class' => 'imag',  'width' => '150', 'height' => '150' ]), [ 'target' => '_blank' ]) !!}
    @endforeach

@endsection
