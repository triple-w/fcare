<?php $__env->startSection('title', 'Ver factura'); ?>

<?php $__env->startSection('content'); ?>

    <div class="margin-bottom-50">
        <div class="invoice-block">
            <div class="row">
            <div class="col-md-6">
                <h4>
                    <?php /* Amazon Delivery */ ?>
                    <br />
                    <br />
                    <?php $image = HTML::image('webroot/themes/themeforest-9110062/Templates/default/images/users/user-35.jpg', 'User', []); $__data['image'] = HTML::image('webroot/themes/themeforest-9110062/Templates/default/images/users/user-35.jpg', 'User', []); ?>
                    <?php if(!empty(Auth::user()->getLogo())): ?>
                        <?php $logo = Auth::user()->getLogo()->getName(); $__data['logo'] = Auth::user()->getLogo()->getName(); ?>
                        <?php $image = HTML::image("uploads/users_logos/thumbnails/{$logo}", 'User', []); $__data['image'] = HTML::image("uploads/users_logos/thumbnails/{$logo}", 'User', []); ?>
                    <?php endif; ?>
                    <?php echo $image; ?>

                </h4>
                <address>
                    <br>
                      <?php echo e($perfil->getNoExt()); ?> <?php echo e($perfil->getCalle()); ?><br>
                      <?php echo e($perfil->getMunicipio()); ?>, <?php echo e($perfil->getEstado()); ?> <?php echo e($perfil->getCodigoPostal()); ?> <br>
                      <abbr title="Phone">TEL:</abbr> <?php echo e($perfil->getTelefono()); ?>

                    <br />
                    <br />
                </address>
            </div>
            <div class="col-md-6 text-right">
                <h1>FACTURA</h1>
                        <?php $xml = new DOMDocument(); $__data['xml'] = new DOMDocument(); ?><?php $xml->loadXML($factura->getXml()) ?>
                        <?php $comprobante = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0]; $__data['comprobante'] = $xml->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', '*')[0]; ?>
                        <h4><?php echo e(empty($comprobante->getAttribute('serie')) ? $comprobante->getAttribute('Serie') : $comprobante->getAttribute('serie')); ?> - <?php echo e(empty($comprobante->getAttribute('folio')) ? $comprobante->getAttribute('Folio') : $comprobante->getAttribute('folio')); ?></h4>
                    <?php /* <a href="#" class="btn btn-primary btn-sm invoice-print"><i class="icon-print-2"></i> Print</a> */ ?>
                <h4><?php echo e($factura->getRazonSocial()); ?></h4>
                <address>
                  <?php echo e($factura->getNoExt()); ?> <?php echo e($factura->getCalle()); ?><br>
                  <?php echo e($factura->getMunicipio()); ?>, <?php echo e($factura->getEstado()); ?> <?php echo e($factura->getCodigoPostal()); ?> <br>
                  <abbr title="Phone">TEL:</abbr> <?php echo e($factura->getTelefono()); ?>

                </address>
                <p><strong>FECHA : </strong> <?php echo e($factura->getFecha()->toFormattedDateString()); ?></p>
                        <p><strong>ESTATUS : </strong>
                        <?php $cssClass = 'success'; $__data['cssClass'] = 'success'; ?>
                        <?php if($factura->getEstatus() === \App\Models\Facturas::CANCELADA): ?>
                            <?php $cssClass = 'danger'; $__data['cssClass'] = 'danger'; ?>
                        <?php endif; ?>
                        <span class="label label-<?php echo e($cssClass); ?>"><?php echo e($factura->getEstatus()); ?></span></p>
                <br />
                <br />
            </div>
        </div>
            <div class="table-responsive">
                <table class="table table-hover text-right">
                    <thead>
                        <tr>
                            <th>DESCRIPCION</th>
                            <th>CLAVE</th>
                            <th>CANTIDAD</th>
                            <th>PRECIO UNITARIO</th>
                            <th width="100">TOTAL</th>
                        </tr>
                    </thead>
                    <?php $subTotal = 0.00; $__data['subTotal'] = 0.00; ?>
                    <tbody>
                        <?php
app('blade.helpers')->get('loop')->newLoop($factura->getDetalles());
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $detalle):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <tr>
                                <td><?php echo e($detalle->getDescripcion()); ?></td>
                                <td><?php echo e($detalle->getClave()); ?></td>
                                <td><?php echo e($detalle->getCantidad()); ?></td>
                                <td>$<?php echo e($detalle->getNuevoPrecio()); ?></td>
                                <td>$<?php echo e($detalle->getImporte()); ?></td>
                                <?php $subTotal = $subTotal + $detalle->getImporte(); $__data['subTotal'] = $subTotal + $detalle->getImporte(); ?>
                            </tr>
                        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Subtotal</strong></td>
                            <td>$<?php echo e(number_format($subTotal, 2, '.', '')); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Descuento</strong></td>
                            <td>$<?php echo e(number_format($factura->getDescuento(), 2, '.', '')); ?></td>
                        </tr>
                        <?php $ret = 0.00; $__data['ret'] = 0.00; ?>
                        <?php $tras = 0.00; $__data['tras'] = 0.00; ?>
                        <?php
app('blade.helpers')->get('loop')->newLoop($factura->getImpuestos());
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $impuesto):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <?php if($impuesto->getTipo() === 'TRAS'): ?>
                                <?php $tras = $tras + $impuesto->getMonto(); $__data['tras'] = $tras + $impuesto->getMonto(); ?>
                            <?php else: ?>
                                <?php $ret = $ret - $impuesto->getMonto(); $__data['ret'] = $ret - $impuesto->getMonto(); ?>
                            <?php endif; ?>
                            <tr>
                                <td colspan="4" class="text-right"><strong><?php echo e(\App\Models\Facturas::getNombreImpuestos($impuesto->getImpuesto())); ?></strong></td>
                                <td>$<?php echo e(number_format($impuesto->getMonto(), 2, '.', '')); ?></td>
                            </tr>
                        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>                     
                        <tr>
                            <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                            <td>
                                <?php $monto = $factura->getMontoTotal($xml); $__data['monto'] = $factura->getMontoTotal($xml); ?>
                                $ <?php echo e(number_format((double)$monto, '2', '.', '')); ?>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php echo HTML::link(URL::previous(), '<i class="icmn-undo" aria-hidden="true"></i> Regresar', [ 'class' => 'btn btn-info', 'style' => 'float:right' ]); ?>

    </div>

    

<?php $__env->stopSection(); ?>
