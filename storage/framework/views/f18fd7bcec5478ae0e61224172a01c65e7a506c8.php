
<?php $__env->startSection('title', 'Facturas'); ?>

<?php $__env->startSection('content'); ?>

    <div id="modal-envio-facturas" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Envio de facturas</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <?php echo BootForm::open([ 'id' => 'envio-email', 'action' => 'Users\FacturasV33Controller@postEnvioEmail', 'method' => 'POST' ]);; ?>

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

    <?php echo HTML::link(action('Users\FacturasV33Controller@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nueva Factura', [ 'class' => 'btn btn-default' ]); ?>


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
            <?php
app('blade.helpers')->get('loop')->newLoop($facturas);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $factura):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                <tr>
                    <td>
                        <?php $xml = new DOMDocument(); $__data['xml'] = new DOMDocument(); ?><?php $xml->loadXML($factura->getXml()) ?>
                        <?php $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0]; $__data['comprobante'] = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0]; ?>
                        <?php echo e(empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie')); ?> - <?php echo e(empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio')); ?>

                    </td>
                    <td>
                        <?php echo e($factura->getRfc()); ?>

                    </td>
                    <td>
                        <?php echo e($factura->getRazonSocial()); ?>

                    </td>
                    <td>
                        <?php if(!empty($factura->getFechaFactura())): ?>
                            <?php echo e($factura->getFechaFactura()->toFormattedDateString()); ?>

                        <?php else: ?>
                            <?php echo e($factura->getFecha()->toFormattedDateString()); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php $strComprobante = $factura->getNombreComprobante(); $__data['strComprobante'] = $factura->getNombreComprobante(); ?>
                        <?php if(!empty($strComprobante)): ?>
                            <?php echo e(constant("App\Models\Facturas::$strComprobante")); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($factura->getEstatus() === \App\Models\Facturas::TIMBRADA): ?>
                            <?php echo Label::success($factura->getEstatus()); ?>

                        <?php else: ?>
                            <?php echo Label::danger($factura->getEstatus()); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php $monto = $factura->getMontoTotal($xml); $__data['monto'] = $factura->getMontoTotal($xml); ?>
                        $ <?php echo e(number_format((double)$monto, '2', '.', '')); ?>

                    </td>
                    <td>
                        <?php echo HTML::link('#', '<i class="icmn-envelop" aria-hidden="true"></i>', [ 'class' => 'btn btn-default envio-facturas', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Envio por email', 'data-id' => $factura->getId() ]); ?>

                        <?php echo HTML::link(action('Users\FacturasV33Controller@getXml', [ 'id' => $factura->getId() ]), '<i class="icmn-file-xml2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'XML Download' ]); ?>

                        <?php echo HTML::link(action('Users\FacturasV33Controller@getPdf', [ 'id' => $factura->getId() ]), '<i class="icmn-file-pdf" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'PDF Download' ]); ?>

                        <?php echo HTML::link(action('Users\FacturasV33Controller@getInvoice', [ 'id' => $factura->getId() ]), '<i class="icmn-file-eye2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'VER' ]); ?>

                        <?php if($factura->getEstatus() === \App\Models\Facturas::TIMBRADA): ?>
                            <?php echo HTML::link(action('Users\FacturasV33Controller@getCancelar', [ 'id' => $factura->getId() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'CANCELAR' , 'data-title' => 'Cancelación de Factura', 'data-content' => 'Esta seguro de Cancelar la factura?' ]); ?>

                        <?php else: ?>
                            <?php echo HTML::link(action('Users\FacturasV33Controller@getAcuse', [ 'id' => $factura->getId() ]), '<i class="icmn-file-xml2" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Descargar XML Acuse' ]); ?>

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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/limitless_14/generals.js'); ?>

<?php $__env->appendSection(); ?>
