@section('title', 'Ver factura')

@section('content')

	<div class="margin-bottom-50">
        <div class="invoice-block">
            <div class="row">
            <div class="col-md-6">
                <h4>
                    {{-- Amazon Delivery --}}
                    <br />
                    <br />
                    @set('image', HTML::image('webroot/themes/themeforest-9110062/Templates/default/images/users/user-35.jpg', 'User', []))
	                @if (!empty(Auth::user()->getLogo()))
	                    @set("logo", Auth::user()->getLogo()->getName())
	                    @set('image', HTML::image("uploads/users_logos/thumbnails/{$logo}", 'User', []))
	                @endif
                    {!! $image !!}
                </h4>
                <address>
                    <br>
					  {{ $perfil->getNoExt() }} {{ $perfil->getCalle() }}<br>
					  {{ $perfil->getMunicipio() }}, {{ $perfil->getEstado() }} {{ $perfil->getCodigoPostal() }} <br>
					  <abbr title="Phone">TEL:</abbr> {{ $perfil->getTelefono() }}
                    <br />
                    <br />
                </address>
            </div>
            <div class="col-md-6 text-right">
                <h1>FACTURA</h1>
            		@set('textos', explode("\n", $factura->getSolicitudTimbre()))
					@set('linea', explode("|", $textos[1]))
					<h4>#{{ $linea[1] }} - {{ $linea[2] }}</h4>
					{{-- <a href="#" class="btn btn-primary btn-sm invoice-print"><i class="icon-print-2"></i> Print</a> --}}
				<h4>{{ $factura->getRazonSocial() }}</h4>
                <address>
				  {{ $factura->getNoExt() }} {{ $factura->getCalle() }}<br>
				  {{ $factura->getMunicipio() }}, {{ $factura->getEstado() }} {{ $factura->getCodigoPostal() }} <br>
				  <abbr title="Phone">TEL:</abbr> {{ $factura->getTelefono() }}
				</address>
                <p><strong>FECHA : </strong> {{ $factura->getFecha()->toFormattedDateString() }}</p>
						<p><strong>ESTATUS : </strong>
						@set('cssClass', 'success')
						@if ($factura->getEstatus() === \App\Models\Facturas::CANCELADA)
							@set('cssClass', 'danger')
						@endif
						<span class="label label-{{ $cssClass }}">{{ $factura->getEstatus() }}</span></p>
                <br />
                <br />
            </div>
        </div>
            <div class="table-responsive">
                <table class="table table-hover text-right">
                    <thead>
						<tr>
							<th>CLAVE</th>
							<th>CANTIDAD</th>
							<th>PRECIO UNITARIO</th>
							<th width="100">TOTAL</th>
						</tr>
					</thead>
                    @set('subTotal', 0.00)
					<tbody>
						@foreach ($factura->getDetalles() as $detalle)
							<tr>
								<td>{{ $detalle->getClave() }}</td>
								<td>{{ $detalle->getCantidad() }}</td>
								<td>${{ $detalle->getNuevoPrecio() }}</td>
								<td>${{ $detalle->getImporte() }}</td>
								@set('subTotal', $subTotal + $detalle->getImporte())
							</tr>
						@endforeach
						<tr>
							<td colspan="3" class="text-right"><strong>Subtotal</strong></td>
							<td>${{ number_format($subTotal, 2, '.', '') }}</td>
						</tr>
						<tr>
							<td colspan="3" class="text-right"><strong>Descuento</strong></td>
							<td>${{ number_format($factura->getDescuento(), 2, '.', '') }}</td>
						</tr>
						@set('ret', 0.00)
						@set('tras', 0.00)
						@foreach ($factura->getImpuestos() as $impuesto)
							@if ($impuesto->getTipo() === 'TRAS')
								@set('tras', $tras + $impuesto->getMonto())
							@else
								@set('ret', $ret - $impuesto->getMonto())
							@endif
							<tr>
								<td colspan="3" class="text-right"><strong>{{ $impuesto->getImpuesto() }}</strong></td>
								<td>${{ number_format($impuesto->getMonto(), 2, '.', '') }}</td>
							</tr>
						@endforeach						
						<tr>
							<td colspan="3" class="text-right"><strong>TOTAL</strong></td>
							<td>${{ number_format(($subTotal + $tras) - $factura->getDescuento() - $ret, 2, '.', '') }}</td>
						</tr>
					</tbody>
                </table>
            </div>
        </div>
        {!! HTML::link(URL::previous(), '<i class="icmn-undo" aria-hidden="true"></i> Regresar', [ 'class' => 'btn btn-info', 'style' => 'float:right' ]) !!}
    </div>

	

@endsection