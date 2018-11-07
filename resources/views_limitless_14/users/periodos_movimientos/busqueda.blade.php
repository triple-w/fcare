
@section('title', 'Movimientos')

@section('content')

    <div class="well">
        <h3>Contabilidad del Mes</h3>
        <h4>Ingresos: ${{ number_format($totalEmitidos, 2, '.', ',') }}</h4>
        <h4>Egresos: ${{ number_format($totalRecibidos, 2, '.', ',') }}</h4>
    </div>
    <br />
    <br />

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

        @if (isset($emitidos) && isset($recibidos))
            <!-- Basic tabs -->
            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#basic-tab1" data-toggle="tab">Ingresos</a></li>
                        <li><a href="#basic-tab2" data-toggle="tab">Egresos</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="basic-tab1">
                            <h3>INGRESOS</h3>
                            <div class="margin-bottom-50">
                                <div class="table-responsive">
                                    <table class="table table-hover nowrap" width="100%" datatable>
                                        <thead>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>UUID</th>
                                                <th>Retencion IVA</th>
                                                <th>Retencion ISR</th>
                                                <th>Traslado IVA</th>
                                                <th>Traslado IEPS</th>
                                                <th>Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recibidos as $movimiento)
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
                                                    <td>{{ number_format($movimiento->getMonto(), 2, '.', ',') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="basic-tab2">
                            <h3>EGRESOS</h3>
                            <div class="margin-bottom-50">
                                <div class="table-responsive">
                                    <table class="table table-hover nowrap" width="100%" datatable>
                                        <thead>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>UUID</th>
                                                <th>Retencion IVA</th>
                                                <th>Retencion ISR</th>
                                                <th>Traslado IVA</th>
                                                <th>Traslado IEPS</th>
                                                <th>Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($emitidos as $movimiento)
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
                                                    <td>{{ number_format($movimiento->getMonto(), 2, '.', ',') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /basic tabs -->
        @endif
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
