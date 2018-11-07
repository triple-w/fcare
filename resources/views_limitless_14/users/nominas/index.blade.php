
@section('title', 'Facturas')

@section('content')

    <div id="modal-envio-facturas" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Envio de nomina</h4>
          </div>
          <div class="modal-body">
            {!! BootForm::open([ 'id' => 'envio-email', 'action' => 'Users\NominasController@postEnvioEmail', 'method' => 'POST' ]); !!}
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

    {!! HTML::link(action('Users\NominasController@getAdd'), '<i class="icon-plus2" aria-hidden="true"></i> Nueva Nomina', [ 'class' => 'btn btn-default' ]) !!}

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" data-order="[[ 1, &quot;desc&quot; ]]" datatable>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Empleado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nominas as $nomina)
                        <tr>
                            <td>
                                @set('document', new \DOMDocument($nomina->getSolicitudTimbre()))
                                <?php $document->loadXML($nomina->getSolicitudTimbre()) ?>
                                @set('comprobante', $comprobante = $document->getElementsByTagName('Comprobante')[0])
                                {{ $comprobante->getAttribute('serie') }} - {{ $comprobante->getAttribute('folio') }}
                            </td>
                            <td>
                                {{ $document->getElementsByTagName('Receptor')[0]->getAttribute('rfc') }}
                            </td>
                            <td>
                                {!! HTML::link('#', '<i class="icon-envelop" aria-hidden="true"></i>', [ 'class' => 'btn btn-default envio-facturas', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Envio por email', 'data-id' => $nomina->getId() ]) !!}
                                {!! HTML::link(action('Users\NominasController@getXml', [ 'id' => $nomina->getId() ]), '<i class="icon-file-xml2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'XML Download' ]) !!}
                                {!! HTML::link(action('Users\NominasController@getPdf', [ 'id' => $nomina->getId() ]), '<i class="icon-file-pdf" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'PDF Download' ]) !!}
                                {!! HTML::link(action('Users\NominasController@getInvoice', [ 'id' => $nomina->getId() ]), '<i class="icon-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'VER' ]) !!}
                                @if ($nomina->getEstatus() === \App\Models\Facturas::TIMBRADA)
                                    {!! HTML::link(action('Users\NominasController@getCancelar', [ 'id' => $nomina->getId() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'CANCELAR' , 'data-title' => 'Cancelación de Factura', 'data-content' => 'Esta seguro de Cancelar la factura?' ]) !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/limitless_14/generals.js') !!}
    {!! HTML::scriptLocal('webroot/js/limitless_14/nominas_index.js') !!}
@append
