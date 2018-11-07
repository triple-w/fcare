@section('title', 'Editar Reporte de pago')

@section('content')

    {!! BootForm::open([ 'files' => true, 'method' => 'POST' ]) !!}
        {!! BootForm::text('cantidad', 'Cantidad', $pago->getCantidad(), []) !!}
        {!! BootForm::textarea('observaciones', 'Observaciones', $pago->getObservaciones(), []) !!}
        {!! BootForm::file('images[]', 'Imagenes', [ 'id' => 'imagenes', 'accept' => '.png,.jpg,.jpeg,.gif,.bmp', 'multiple' => 'multiple' ]); !!}
        @foreach ($pago->getImagenes() as $image)
            {!! HTML::image("uploads/users_reportar_pagos/{$image->getName()}", '', [ 'class' => 'imag',  'width' => '150', 'height' => '150' ]) !!}
            {!! HTML::link(action('Users\ReportarPagosController@getDeleteImagen',
                    [ 'id' => $image->getId() ]), 'Borrar', 
                    ['class' => 'btn btn-default' ]) !!}
        @endforeach
        <br />
        <br />
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection
