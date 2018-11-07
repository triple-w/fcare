@section('title', 'Agregar Periodo')

@section('content')

    {!! Alert::info('Espera, no cerrar ventana, no hacer click, no refrescar') !!}
    {!! BootForm::open([ 'id' => 'descarga-periodo' ]) !!}
        @set('meses', [
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12',
        ])
        @set('anios', [
            '2013' => '2013',
            '2014' => '2014',
            '2015' => '2015',
            '2016' => '2016',
            '2017' => '2017',
            '2018' => '2018',
        ])
        <div class="row">
            <div class="col-md-3">
                {!! BootForm::select('mes', 'Mes', $meses, null, []) !!}
            </div>
            <div class="col-md-3">
                {!! BootForm::select('anio', 'Año', $anios, null, []) !!}
            </div>
        </div>
        {!! BootForm::text('captcha', 'Captcha', null, []) !!}
        <img src="data:image/jpeg;base64,{{ $imagen }}" />
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/periodos_add.js?v=1.0.0') !!}
@append
