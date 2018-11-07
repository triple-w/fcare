@section('title', 'Agregar Producto')

@section('content')

    {!! BootForm::open() !!}
        {!! BootForm::select('claveProdServ', 'Clave de Servicio', [], [], [ 'id' => 'clave-prod-serv', 'data-url' => 'productos/clave-prod-serv' ]) !!}
        {!! BootForm::select('claveUnidad', 'Clave de Unidad', [], [], [ 'id' => 'clave-unidad', 'data-url' => 'productos/clave-unidad' ]) !!}
        {!! BootForm::text('clave', 'Clave', null, []) !!}
        {!! BootForm::text('unidad', 'Unidad', null, []) !!}
        {!! BootForm::text('precio', 'Precio', null, []) !!}
        {!! BootForm::text('descripcion', 'Descripcion', null, []) !!}
        {!! BootForm::textarea('observaciones', 'Observaciones', null, []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection

@section('scripts')
    {!! HTML::script('assets/js/plugins/forms/selects/select2.min.js') !!}
    {!! HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/productos_add.js') !!}
@append