@section('title', 'Ver Reporte de pago')

@section('content')

    <h3>Usuario</h3>
    <p>{{ $pago->getUser()->getUsername() }}</p>

    <h3>Cantidad</h3>
    <p>{{ $pago->getCantidad() }}</p>

    <h3>Fecha</h3>
    <p>{{ $pago->getFecha()->format('Y-m-d H:i:s') }}</p>

    <h3>Observaciones</h3>
    <p>{{ $pago->getObservaciones() }}</p>

    @foreach ($pago->getImagenes() as $image)
        {!!  HTML::link(asset("uploads/users_reportar_pagos/{$image->getName()}"), HTML::image("uploads/users_reportar_pagos/{$image->getName()}", '', [ 'class' => 'imag',  'width' => '150', 'height' => '150' ]), [ 'target' => '_blank' ]) !!}
    @endforeach

    @if (!$pago->getRevisado())
        <div class="row">
            <div class="col-md-12">
                {!! HTML::link(action('ReportarPagos\ReportarPagosController@getAprobarPago', [ 'id' => $pago->getid() ]), '<i class="icmn-file-check2" aria-hidden="true"></i>', [ 'class' => 'btn btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Aprobar' ]) !!}
                {!! HTML::link(action('ReportarPagos\ReportarPagosController@getNoAprobarPago', [ 'id' => $pago->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'No Aprobar' ]) !!}
            </div>
        </div>
    @endif
@endsection
