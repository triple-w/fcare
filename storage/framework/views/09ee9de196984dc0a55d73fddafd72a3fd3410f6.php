
<?php $__env->startSection('title', 'Nominas'); ?>

<?php $__env->startSection('content'); ?>

    <div id="modal-envio-facturas" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Envio de nomina</h4>
          </div>
          <div class="modal-body">
            <?php echo BootForm::open([ 'id' => 'envio-email', 'action' => 'Users\NominasController@postEnvioEmail', 'method' => 'POST' ]);; ?>

                <?php echo BootForm::email('email', 'Email', Auth::user()->getEmail(), []); ?>

                <?php echo BootForm::submit('Enviar'); ?>

            <?php echo BootForm::close(); ?>

          </div>
          <div class="modal-footer">
            <input type="hidden" id="href-eliminar" value="">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php echo HTML::link(action('Users\NominasController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nueva Nomina', [ 'class' => 'btn btn-default' ]); ?>


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
                    <?php
app('blade.helpers')->get('loop')->newLoop($nominas);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $nomina):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td>
                                <?php $document = new \DOMDocument($nomina->getSolicitudTimbre()); $__data['document'] = new \DOMDocument($nomina->getSolicitudTimbre()); ?><?php $document->loadXML($nomina->getSolicitudTimbre()) ?>
                                <?php $comprobante = $comprobante = $document->getElementsByTagName('Comprobante')[0]; $__data['comprobante'] = $comprobante = $document->getElementsByTagName('Comprobante')[0]; ?>
                                <?php echo e($comprobante->getAttribute('serie')); ?> - <?php echo e($comprobante->getAttribute('folio')); ?>

                            </td>
                            <td>
                                <?php echo e($document->getElementsByTagName('Receptor')[0]->getAttribute('rfc')); ?>

                            </td>
                            <td>
                                <?php echo HTML::link('#', '<i class="icmn-envelop" aria-hidden="true"></i>', [ 'class' => 'btn btn-default envio-facturas', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Envio por email', 'data-id' => $nomina->getId() ]); ?>

                                <?php echo HTML::link(action('Users\NominasController@getXml', [ 'id' => $nomina->getId() ]), '<i class="icmn-file-xml2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'XML Download' ]); ?>

                                <?php echo HTML::link(action('Users\NominasController@getPdf', [ 'id' => $nomina->getId() ]), '<i class="icmn-file-pdf" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'PDF Download' ]); ?>

                                <?php echo HTML::link(action('Users\NominasController@getInvoice', [ 'id' => $nomina->getId() ]), '<i class="icmn-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'VER' ]); ?>

                                <?php if($nomina->getEstatus() === \App\Models\Facturas::TIMBRADA): ?>
                                    <?php echo HTML::link(action('Users\NominasController@getCancelar', [ 'id' => $nomina->getId() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'CANCELAR' , 'data-title' => 'Cancelación de Factura', 'data-content' => 'Esta seguro de Cancelar la factura?' ]); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/limitless_14/generals.js'); ?>

    <?php echo HTML::scriptLocal('webroot/js/limitless_14/nominas_index.js'); ?>

<?php $__env->appendSection(); ?>
