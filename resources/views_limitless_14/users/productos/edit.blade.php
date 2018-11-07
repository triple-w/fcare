@section('title', 'Editar Producto')

@section('content')

    {!! BootForm::open() !!}
    {!! BootForm::select('claveProdServ', 'Clave de Servicio', [], [], [ 'id' => 'clave-prod-serv', 'data-id' => $producto->getClaveProdServ()->getId(), 'data-text' => $producto->getClaveProdServ()->getDescripcion(), 'data-url' => 'productos/clave-prod-serv' ]) !!}
    {!! BootForm::select('claveUnidad', 'Clave de Unidad', [], [], [ 'id' => 'clave-unidad', 'data-id' => $producto->getClaveUnidad()->getid(), 'data-text' => $producto->getClaveUnidad()->getDescripcion(), 'data-url' => 'productos/clave-unidad' ]) !!}
        {!! BootForm::text('clave', 'Clave', $producto->getClave(), []) !!}
        {!! BootForm::text('unidad', 'Unidad', $producto->getUnidad(), []) !!}
        {!! BootForm::text('precio', 'Precio', $producto->getPrecio(), []) !!}
        {!! BootForm::text('descripcion', 'Descripcion', $producto->getDescripcion(), []) !!}
        {!! BootForm::textarea('observaciones', 'Observaciones', $producto->getObservaciones(), []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection

@section('scripts')
    {!! HTML::script('assets/js/plugins/forms/selects/select2.min.js') !!}
    {!! HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/productos_add.js') !!}
@append