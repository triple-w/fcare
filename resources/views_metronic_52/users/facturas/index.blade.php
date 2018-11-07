
@section('title', 'Facturas')

@section('content')

    <div id="modal-envio-facturas" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Envio de facturas</h4>
          </div>
          <div class="modal-body">
            {!! BootForm::open([ 'id' => 'envio-email', 'action' => 'Users\FacturasController@postEnvioEmail', 'method' => 'POST' ]); !!}
                {!! BootForm::email('email', 'Email', Auth::user()->getEmail(), []) !!}
                {!! BootForm::submit('Enviar') !!}
            {!! BootForm::close() !!}
          </div>
          <div class="modal-footer">
            <input type="hidden" id="href-eliminar" value="">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {!! HTML::link(action('Users\FacturasController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nueva Factura', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <table class="table" data-order="[[ 3, &quot;desc&quot; ]]" datatable>
        <thead>
            <tr>
                <th>ID</th>
                <th>RFC</th>
                <th>Razon Social</th>
                <th>Fecha</th>
                <th>Nombre de Comprobante</th>
                <th>Estatus</th>
                <th>Monto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facturas as $factura)
                <tr>
                    <td>
                        @set('textos', explode("\n", $factura->getSolicitudTimbre()))
                        @set('linea', explode("|", $textos[1]))
                        {{ $linea[1] }} - {{ $linea[2] }}
                    </td>
                    <td>
                        {{ $factura->getRfc() }}
                    </td>
                    <td>
                        {{ $factura->getRazonSocial() }}
                    </td>
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
                        @set('monto', $factura->getMontoTotal())
                        $ {{ number_format((double)$monto, '2', '.', '') }}
                    </td>
                    <td>
                        {!! HTML::link('#', '<i class="icmn-envelop" aria-hidden="true"></i>', [ 'class' => 'btn btn-default envio-facturas', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Envio por email', 'data-id' => $factura->getId() ]) !!}
                        {!! HTML::link(action('Users\FacturasController@getXml', [ 'id' => $factura->getId() ]), '<i class="icmn-file-xml2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'XML Download' ]) !!}
                        {!! HTML::link(action('Users\FacturasController@getPdf', [ 'id' => $factura->getId() ]), '<i class="icmn-file-pdf" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'PDF Download' ]) !!}
                        {!! HTML::link(action('Users\FacturasController@getInvoice', [ 'id' => $factura->getId() ]), '<i class="icmn-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'VER' ]) !!}
                        @if ($factura->getEstatus() === \App\Models\Facturas::TIMBRADA)
                            {!! HTML::link(action('Users\FacturasController@getCancelar', [ 'id' => $factura->getId() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'CANCELAR' , 'data-title' => 'Cancelación de Factura', 'data-content' => 'Esta seguro de Cancelar la factura?' ]) !!}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/facturas_index.js') !!}
@append
