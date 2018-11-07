
@section('title', 'Movimientos')

@section('content')

    <div class="margin-bottom-50">
        {!! BootForm::open() !!}
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
            ])
            <div class="row">
                <div class="col-md-3">
                    {!! BootForm::select('mes', 'Mes', $meses, null, []) !!}
                </div>
                <div class="col-md-3">
                    {!! BootForm::select('anio', 'Año', $anios, null, []) !!}
                </div>
            </div>
            {!! BootForm::submit('Buscar'); !!}
        {!! BootForm::close(); !!}

        @if (isset($movimientos) && count($movimientos) > 0)
            {!! HTML::link(action('Users\PeriodosMovimientosController@getDownloadZip', [ 'mes' => $request['mes'], 'anio' => $request['anio'], 'idUser' => $user->getId() ]), 'Descargar ZIP', [ 'class' => 'btn btn-success' ]) !!}
            {!! HTML::link(action('Users\PeriodosMovimientosPropuestasController@getAdd', [ 'id' => $user->getId(), 'mes' => $request['mes'], 'anio' => $request['anio'] ]), '<i class="icon-plus2" aria-hidden="true"></i> Nueva Propuesta', [ 'class' => 'btn btn-default' ]) !!}
            <table class="table table-hover nowrap" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>UUID</th>
                        <th>Retencion IVA</th>
                        <th>Retencion ISR</th>
                        <th>Traslado IVA</th>
                        <th>Traslado IEPS</th>
                        <th>Deduccion</th>
                        <th>Tipo de Gasto</th>
                        <th>Clasificacion</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movimientos as $movimiento)
                        <tr>
                            <td>{{ $movimiento->getDocumento()->getTipo() }}</td>
                            <td>{{ $movimiento->getDocumento()->getDatos()['uuid'] }}</td>
                            <td>
                                @set('retenciones', $movimiento->getDocumento()->getRetenciones())
                                @set('retencionIVA', 0)
                                @foreach ($retenciones as $retencion)
                                    @if ($retencion['impuesto'] === 'IVA')
                                        @set('retencionIVA', $retencion['importe'])
                                    @endif
                                @endforeach
                                {{ $retencionIVA }}
                            </td>
                            <td>
                                @set('retencionISR', 0)
                                @foreach ($retenciones as $retencion)
                                    @if ($retencion['impuesto'] === 'ISR')
                                        @set('retencionISR', $retencion['importe'])
                                    @endif
                                @endforeach
                                {{ $retencionISR }}
                            </td>
                            <td>
                                @set('traslados', $movimiento->getDocumento()->getTraslados())
                                @set('trasladoIVA', 0)
                                @foreach ($traslados as $traslado)
                                    @if ($traslado['impuesto'] === 'IVA')
                                        @set('trasladoIVA', $traslado['importe'])
                                    @endif
                                @endforeach
                                {{ $trasladoIVA }}
                            </td>
                            <td>
                                @set('trasladoIEPS', 0)
                                @foreach ($traslados as $traslado)
                                    @if ($traslado['impuesto'] === 'IEPS')
                                        @set('trasladoIEPS', $traslado['importe'])
                                    @endif
                                @endforeach
                                {{ $trasladoIEPS }}
                            </td>
                            <td>{{ $movimiento->getDeduccion() }}</td>
                            <td>{{ $movimiento->getTipoGasto() }}</td>
                            <td>{{ $movimiento->getClasificacion() }}</td>
                            <td>{{ number_format($movimiento->getMonto(), 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3>No se encontraron movimientos para ese periodo.</h3>
        @endif
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
