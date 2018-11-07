
@section('title', 'Pagos')

@section('content')

    <div id="modal-envio-facturas" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Envio de facturas</h4>
          </div>
          <div class="modal-body">
            {!! BootForm::open([ 'id' => 'envio-email', 'action' => 'Users\FacturasV33Controller@postEnvioEmail', 'method' => 'POST' ]); !!}
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

    {!! HTML::link(action('Users\ComplementosV33Controller@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Pago', [ 'class' => 'btn btn-default' ]) !!}

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
            @foreach ($complementos as $complemento)
                <tr>
                    <td>
                        @set('xml', new DOMDocument())
                        <?php $xml->loadXML($complemento->getXml()) ?>
                        @set('comprobante', $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0])
                        {{ empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie') }} - {{ empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio') }}
                    </td>
                    <td>
                        {{ $complemento->getRfc() }}
                    </td>
                    <td>
                        {{ $complemento->getRazonSocial() }}
                    </td>
                    <td>
                        @if (!empty($complemento->getFecha()))
                            {{ $complemento->getFecha()->toFormattedDateString() }}
                        @else
                            {{ $complemento->getFecha()->toFormattedDateString() }}
                        @endif
                    </td>
                    <td>
                        {{ 'Complemento de Pago' }}
                    </td>
                    <td>
                        @if ($complemento->getEstatus() === \App\Models\Complementos::TIMBRADA)
                            {!! Label::success($complemento->getEstatus()) !!}
                        @else
                            {!! Label::danger($complemento->getEstatus()) !!}
                        @endif
                    </td>
                    <td>
                        @set('monto', $comprobante->getAttribute('total'))
                        $ {{ number_format((double)$monto, '2', '.', '') }}
                    </td>
                    <td>
                        {!! HTML::link('#', '<i class="icon-file-empty" aria-hidden="true"></i>', [ 'class' => 'btn btn-default envio-facturas', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Envio por email', 'data-id' => $complemento->getId() ]) !!}
                        {!! HTML::link(action('Users\ComplementosV33Controller@getXml', [ 'id' => $complemento->getId() ]), '<i class="icon-file-xml" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'XML Download' ]) !!}
                        {!! HTML::link(action('Users\ComplementosV33Controller@getPdf', [ 'id' => $complemento->getId() ]), '<i class="icon-file-pdf" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'PDF Download' ]) !!}
                        {!! HTML::link(action('Users\ComplementosV33Controller@getInvoice', [ 'id' => $complemento->getId() ]), '<i class="icon-file-eye" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'VER' ]) !!}
                        @if ($complemento->getEstatus() === \App\Models\Complementos::TIMBRADA)
                            {!! HTML::link(action('Users\ComplementosV33Controller@getCancelar', [ 'id' => $complemento->getId() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'CANCELAR' , 'data-title' => 'Cancelación de Pago', 'data-content' => 'Esta seguro de Cancelar el pago?' ]) !!}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/generals.js') !!}
    {!! HTML::scriptLocal('webroot/js/facturas_index_cleanui.js') !!}
@append
