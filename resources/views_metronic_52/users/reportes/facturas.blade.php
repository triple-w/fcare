
@section('title', 'Reporte de Facturas')

@section('content')

    {!! BootForm::open() !!}
        <div class="row">
            <div class="col-md-6">
                {!! BootForm::text('fechaInicial', 'Fecha Inicial', isset($request) ? $request['fechaInicial'] : null, [ 'class' => 'datepicker', 'required' => 'required' ]) !!}
            </div>
            <div class="col-md-6">
                {!! BootForm::text('fechaFinal', 'Fecha Final', isset($request) ? $request['fechaFinal'] : null, [ 'class' => 'datepicker', 'required' => 'required' ]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                @set('clientes', [])
                @foreach (Auth::user()->getClientes() as $cliente)
                    @set("clientes[$cliente->getRfc()]", $cliente->getRazonSocial() . ' - ' . $cliente->getRfc())
                @endforeach
                {!! BootForm::select('cliente', 'Cliente', [ 'TODOS' => 'Todos' ] + $clientes, isset($request) ? $request['cliente'] : null, []) !!}
            </div>
            <div class="col-md-4">
                {!! BootForm::select('estatus', 'Estado', [ 'TODOS' => 'Todos', 'TIMBRADA' => 'Timbrada', 'CANCELADA' => 'Cancelada' ], isset($request) ? $request['estatus'] : null, []) !!}
            </div>
            <div class="col-md-4">
                {!! BootForm::select('nombreComprobante', 'Nombre de Comprobante', [ 'TODOS' => 'Todos' ] + \App\Models\Facturas::getNombresDocumentos(), isset($request) ? $request['nombreComprobante'] : null, []) !!}
            </div>
        </div>
        {!! BootForm::radios('tipoReporte', 'Tipo', [ 'VER' => 'Ver', 'EXCEL' => 'Excel', 'PDF' => 'PDF' ], 'VER', []) !!}
        {!! BootForm::submit('Aceptar') !!}
    {!! BootForm::close() !!}

    @if (isset($facturas))
        <div class="margin-bottom-50">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Tipo de Comprobante</th>
                            <th>Estado</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                    @set('totalMonto', 0)
                    @foreach ($facturas as $factura)
                        <tr>
                            <td>
                                @set('xml', new DOMDocument())
                                <?php $xml->loadXML($factura->getXml()) ?>
                                @set('comprobante', $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0])
                                {{ empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie') }} - {{ empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio') }}
                            </td>
                            <td>{{ $factura->getRfc() }} - {{ $factura->getRazonSocial() }}</td>
                            <td>
                                @if (!empty($factura->getFechaFactura()))
                                    {{ $factura->getFechaFactura()->toFormattedDateString() }}
                                @else
                                    {{ $factura->getFecha()->toFormattedDateString() }}
                                @endif
                            </td>
                            <td>
                                @set('strComprobante', $factura->getNombreComprobante())
                                @if (!empty($strComprobante))
                                    {{ constant("App\Models\Facturas::$strComprobante") }}
                                @endif
                            </td>
                            <td>
                                @if ($factura->getEstatus() === \App\Models\Facturas::TIMBRADA)
                                    {!! Label::success($factura->getEstatus()) !!}
                                @else
                                    {!! Label::danger($factura->getEstatus()) !!}
                                @endif
                            </td>
                            <td>
                                @set('monto', $factura->getMontoTotal($xml))
                                $ {{ number_format((double)$monto, '2', '.', '') }}
                                @set('totalMonto', $totalMonto + $monto)
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align:right">Monto Total</td>
                        <td>$ {{ number_format((double)$totalMonto, '2', '.', '') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right">Total De Facturas</td>
                        <td>{{ count($facturas) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
@append
