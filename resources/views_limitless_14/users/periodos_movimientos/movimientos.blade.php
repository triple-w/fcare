
@section('title', 'Movimientos')

@section('content')
    <div class="well">
        <h3>Contabilidad del Periodo</h3>
        <h4>Ingresos: ${{ number_format($totalEmitidos, 2, '.', ',') }}</h4>
        <h4>Egresos: ${{ number_format($totalRecibidos, 2, '.', ',') }}</h4>
        <h4>Ingresos Sin Factura: ${{ number_format($ingresoSinFactura, 2, '.', ',') }}</h4>
    </div>
    <br />
    <br />

    {!! HTML::link(action('Users\PeriodosMovimientosController@getDownloadZip', [ 'mes' => $mes, 'anio' => $anio, 'idUser' => $user->getId() ]), 'Descargar ZIP', [ 'class' => 'btn btn-success' ]) !!}
    {!! HTML::link(action('Users\PeriodosMovimientosController@getExportExcel', [ 'id' => $user->getId(), 'mes' => $mes, 'anio' => $anio ]), 'Descargar Excel', [ 'class' => 'btn btn-success' ]) !!}
    {!! HTML::link(action('Users\PeriodosMovimientosPropuestasController@getAdd', [ 'id' => $user->getId(), 'mes' => $mes, 'anio' => $anio ]), '<i class="icon-plus2" aria-hidden="true"></i> Nueva Declaracion', [ 'class' => 'btn btn-default' ]) !!}

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
                                        <th>RFC Emisor</th>
                                        <th>RFC Receptor</th>
                                        <th>Retencion IVA</th>
                                        <th>Retencion ISR</th>
                                        <th>Traslado IVA</th>
                                        <th>Traslado IEPS</th>
                                        <th>Deduccion</th>
                                        <th>Tipo de Gasto</th>
                                        <th>Clasificacion</th>
                                        <th>Monto Pagado</th>
                                        <th>Monto Factura</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emitidos as $movimiento)
                                        <tr>
                                            <td>{{ $movimiento->getDocumento()->getTipo() }}</td>
                                            <td>{{ $movimiento->getDocumento()->getDatos()['uuid'] }}</td>
                                            <td>{{ $movimiento->getDocumento()->getRfcEmisor() }}</td>
                                            <td>{{ $movimiento->getDocumento()->getRfcReceptor() }}</td>
                                            <td>
                                                @set('retenciones', $movimiento->getDocumento()->getRetenciones())
                                                @set('retencionIVA', 0)
                                                @set('montoTotal', str_replace(',', '', substr($movimiento->getDocumento()->getDatos()['total'], 1)))
                                                @foreach ($retenciones as $retencion)
                                                    @if ($retencion['impuesto'] === 'IVA' || $retencion['impuesto'] === '002')
                                                        @set('rtIVA', ($movimiento->getMonto() * $retencion['importe']) / $montoTotal)
                                                        @set('retencionIVA', $retencionIVA + $rtIVA)
                                                    @endif
                                                @endforeach
                                                {{ number_format($retencionIVA, 2, '.', '') }}
                                            </td>
                                            <td>
                                                @set('retencionISR', 0)
                                                @foreach ($retenciones as $retencion)
                                                    @if ($retencion['impuesto'] === 'ISR' || $retencion['impuesto'] === '001')
                                                        @set('rtISR', ($movimiento->getMonto() * $retencion['importe']) / $montoTotal)
                                                        @set('retencionISR', $retencionISR + $rtISR)
                                                    @endif
                                                @endforeach
                                                {{ number_format($retencionISR, 2, '.', '') }}
                                            </td>
                                            <td>
                                                @set('traslados', $movimiento->getDocumento()->getTraslados())
                                                @set('trasladoIVA', 0)
                                                @foreach ($traslados as $traslado)
                                                    @if ($traslado['impuesto'] === 'IVA' || $traslado['impuesto'] === '002')
                                                        @set('trIVA', ($movimiento->getMonto() * $traslado['importe']) / $montoTotal)
                                                        @set('trasladoIVA', $trasladoIVA + $trIVA)
                                                    @endif
                                                @endforeach
                                                {{ number_format($trasladoIVA, 2, '.', '') }}
                                            </td>
                                            <td>
                                                @set('trasladoIEPS', 0)
                                                @foreach ($traslados as $traslado)
                                                    @if ($traslado['impuesto'] === 'IEPS' || $traslado['impuesto'] === '003')
                                                        @set('trIEPS', ($movimiento->getMonto() * $traslado['importe']) / $montoTotal)
                                                        @set('trasladoIEPS', $trasladoIEPS + $trIEPS)
                                                    @endif
                                                @endforeach
                                                {{ number_format($trasladoIEPS, 2, '.', '') }}
                                            </td>
                                            <td>{{ $movimiento->getDeduccion() }}</td>
                                            <td>{{ $movimiento->getTipoGasto() }}</td>
                                            <td>{{ $movimiento->getClasificacion() }}</td>
                                            <td>{{ number_format($movimiento->getMonto(), 2, '.', ',') }}</td>
                                            <td>{{ $movimiento->getDocumento()->getDatos()['total'] }}</td>
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
                                        <th>RFC Emisor</th>
                                        <th>RFC Receptor</th>
                                        <th>Traslados Importes</th>
                                        <th>Traslados Tasas</th>
                                        <th>Traslados Impuestos</th>
                                        <th>Retenciones Importes</th>
                                        <th>Retenciones Impuestos</th>
                                        <th>Monto Pagado</th>
                                        <th>Monto Factura</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recibidos as $movimiento)
                                        <tr>
                                            <td>{{ $movimiento->getDocumento()->getTipo() }}</td>
                                            <td>{{ $movimiento->getDocumento()->getDatos()['uuid'] }}</td>
                                            <td>{{ $movimiento->getDocumento()->getRfcEmisor() }}</td>
                                            <td>{{ $movimiento->getDocumento()->getRfcReceptor() }}</td>
                                            <td>
                                                @set('trasladosImportes', '')
                                                @foreach ($movimiento->getDocumento()->getTraslados() as $key => $traslado)
                                                    @set('trasladosImportes', $trasladosImportes . $traslado['importe'] . ',')
                                                @endforeach
                                                {{ substr($trasladosImportes, 0, -1) }}
                                            </td>
                                            <td>
                                                @set('trasladosTasas', '')
                                                @foreach ($movimiento->getDocumento()->getTraslados() as $key => $traslado)
                                                    @set('trasladosTasas', $trasladosTasas . $traslado['tasa'] . ',')
                                                @endforeach
                                                {{ substr($trasladosTasas, 0, -1) }}
                                            </td>
                                            <td>
                                                @set('trasladosImpuestos', '')
                                                @foreach ($movimiento->getDocumento()->getTraslados() as $key => $traslado)
                                                    @set('trasladosImpuestos', $trasladosImpuestos . $traslado['impuesto'] . ',')
                                                @endforeach
                                                {{ substr($trasladosImpuestos, 0, -1) }}
                                            </td>
                                            <td>
                                                @set('retencionesImportes', '')
                                                @foreach ($movimiento->getDocumento()->getRetenciones() as $key => $retencion)
                                                    @set('retencionesImportes', $retencionesImportes . $retencion['importe'] . ',')
                                                @endforeach
                                                {{ substr($retencionesImportes, 0, -1) }}
                                            </td>
                                            <td>
                                                @set('retencionesImpuestos', '')
                                                @foreach ($movimiento->getDocumento()->getRetenciones() as $key => $retencion)
                                                    {{ $retencion['impuesto'] }},
                                                    @set('retencionesImpuestos', $retencionesImpuestos . $retencion['impuesto'] . ',')
                                                @endforeach
                                                {{ substr($retencionesImpuestos, 0, -1) }}
                                            </td>
                                            <td>{{ number_format($movimiento->getMonto(), 2, '.', ',') }}</td>
                                            <td>{{ $movimiento->getDocumento()->getDatos()['total'] }}</td>
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

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
