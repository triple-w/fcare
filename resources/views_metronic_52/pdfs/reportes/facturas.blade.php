
<style>
	table {
		width: 100%;
	}
	td {
		font-size: 13px;
	}
	th, td {
		border:1px solid black;
		text-align: center;
	}
</style>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Cliente</th>
			<th>Fecha</th>
			<th>Monto</th>
			<th>Estado</th>
			<th>Tipo de Comprobante</th>
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
				@set('monto', $factura->getMontoTotal())
				$ {{ number_format((double)$monto, '2', '.', '') }}
				@set('totalMonto', $totalMonto + $monto)
			</td>
			<td>
				@if ($factura->getEstatus() === \App\Models\Facturas::TIMBRADA)
					{!! Label::success($factura->getEstatus()) !!}
				@else
					{!! Label::danger($factura->getEstatus()) !!}
				@endif
			</td>
			<td>
				@set('strComprobante', $factura->getNombreComprobante())
				@if (!empty($strComprobante))
					{{ constant("App\Models\Facturas::$strComprobante") }}
				@endif
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
