
<?php $__env->startSection('title', 'Pagos'); ?>

<?php $__env->startSection('content'); ?>

    <div id="modal-envio-facturas" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Envio de facturas</h4>
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

    <?php echo HTML::link(action('Users\ComplementosV33Controller@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Pago', [ 'class' => 'btn btn-default' ]); ?>


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
app('blade.helpers')->get('loop')->newLoop($complementos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $complemento):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                <tr>
                    <td>
                        <?php $xml = new DOMDocument(); $__data['xml'] = new DOMDocument(); ?><?php $xml->loadXML($complemento->getXml()) ?>
                        <?php $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0]; $__data['comprobante'] = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0]; ?>
                        <?php echo e(empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie')); ?> - <?php echo e(empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio')); ?>

                    </td>
                    <td>
                        <?php echo e($complemento->getRfc()); ?>

                    </td>
                    <td>
                        <?php echo e($complemento->getRazonSocial()); ?>

                    </td>
                    <td>
                        <?php if(!empty($complemento->getFecha())): ?>
                            <?php echo e($complemento->getFecha()->toFormattedDateString()); ?>

                        <?php else: ?>
                            <?php echo e($complemento->getFecha()->toFormattedDateString()); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo e('Complemento de Pago'); ?>

                    </td>
                    <td>
                        <?php if($complemento->getEstatus() === \App\Models\Complementos::TIMBRADA): ?>
                            <?php echo Label::success($complemento->getEstatus()); ?>

                        <?php else: ?>
                            <?php echo Label::danger($complemento->getEstatus()); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php $monto = $comprobante->getAttribute('total'); $__data['monto'] = $comprobante->getAttribute('total'); ?>
                        $ <?php echo e(number_format((double)$monto, '2', '.', '')); ?>

                    </td>
                    <td>
                        <?php echo HTML::link('#', '<i class="icon-file-empty" aria-hidden="true"></i>', [ 'class' => 'btn btn-default envio-facturas', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Envio por email', 'data-id' => $complemento->getId() ]); ?>

                        <?php echo HTML::link(action('Users\ComplementosV33Controller@getXml', [ 'id' => $complemento->getId() ]), '<i class="icon-file-xml" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'XML Download' ]); ?>

                        <?php echo HTML::link(action('Users\ComplementosV33Controller@getPdf', [ 'id' => $complemento->getId() ]), '<i class="icon-file-pdf" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'PDF Download' ]); ?>

                        <?php echo HTML::link(action('Users\ComplementosV33Controller@getInvoice', [ 'id' => $complemento->getId() ]), '<i class="icon-file-eye" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'VER' ]); ?>

                        <?php if($complemento->getEstatus() === \App\Models\Complementos::TIMBRADA): ?>
                            <?php echo HTML::link(action('Users\ComplementosV33Controller@getCancelar', [ 'id' => $complemento->getId() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'CANCELAR' , 'data-title' => 'Cancelación de Pago', 'data-content' => 'Esta seguro de Cancelar el pago?' ]); ?>

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
    <?php echo HTML::scriptLocal('webroot/js/generals.js'); ?>

    <?php echo HTML::scriptLocal('webroot/js/facturas_index_cleanui.js'); ?>

<?php $__env->appendSection(); ?>
