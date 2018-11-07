
<?php $__env->startSection('title', 'Movimientos'); ?>

<?php $__env->startSection('content'); ?>

    <div class="margin-bottom-50">
        <?php echo BootForm::open(); ?>

            <?php $meses = [
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12',
            ]; $__data['meses'] = [
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12',
            ]; ?>
            <?php $anios = [
                '2013' => '2013',
                '2014' => '2014',
                '2015' => '2015',
                '2016' => '2016',
                '2017' => '2017',
            ]; $__data['anios'] = [
                '2013' => '2013',
                '2014' => '2014',
                '2015' => '2015',
                '2016' => '2016',
                '2017' => '2017',
            ]; ?>
            <div class="row">
                <div class="col-md-3">
                    <?php echo BootForm::select('mes', 'Mes', $meses, null, []); ?>

                </div>
                <div class="col-md-3">
                    <?php echo BootForm::select('anio', 'Año', $anios, null, []); ?>

                </div>
            </div>
            <?php echo BootForm::submit('Buscar');; ?>

        <?php echo BootForm::close();; ?>


        <?php if(isset($movimientos) && count($movimientos) > 0): ?>
            <?php echo HTML::link(action('Users\PeriodosMovimientosController@getDownloadZip', [ 'mes' => $request['mes'], 'anio' => $request['anio'], 'idUser' => $user->getId() ]), 'Descargar ZIP', [ 'class' => 'btn btn-success' ]); ?>

            <?php echo HTML::link(action('Users\PeriodosMovimientosPropuestasController@getAdd', [ 'id' => $user->getId(), 'mes' => $request['mes'], 'anio' => $request['anio'] ]), '<i class="icon-plus2" aria-hidden="true"></i> Nueva Propuesta', [ 'class' => 'btn btn-default' ]); ?>

            <table class="table table-hover nowrap" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>UUID</th>
                        <th>Retencion IVA</th>
                        <th>Retencion ISR</th>
                        <th>Traslado IVA</th>
                        <th>Traslado IEPS</th>
                        <th>Deduccion</th>
                        <th>Tipo de Gasto</th>
                        <th>Clasificacion</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($movimientos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $movimiento):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($movimiento->getDocumento()->getTipo()); ?></td>
                            <td><?php echo e($movimiento->getDocumento()->getDatos()['uuid']); ?></td>
                            <td>
                                <?php $retenciones = $movimiento->getDocumento()->getRetenciones(); $__data['retenciones'] = $movimiento->getDocumento()->getRetenciones(); ?>
                                <?php $retencionIVA = 0; $__data['retencionIVA'] = 0; ?>
                                <?php
app('blade.helpers')->get('loop')->newLoop($retenciones);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $retencion):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <?php if($retencion['impuesto'] === 'IVA'): ?>
                                        <?php $retencionIVA = $retencion['importe']; $__data['retencionIVA'] = $retencion['importe']; ?>
                                    <?php endif; ?>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                <?php echo e($retencionIVA); ?>

                            </td>
                            <td>
                                <?php $retencionISR = 0; $__data['retencionISR'] = 0; ?>
                                <?php
app('blade.helpers')->get('loop')->newLoop($retenciones);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $retencion):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <?php if($retencion['impuesto'] === 'ISR'): ?>
                                        <?php $retencionISR = $retencion['importe']; $__data['retencionISR'] = $retencion['importe']; ?>
                                    <?php endif; ?>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                <?php echo e($retencionISR); ?>

                            </td>
                            <td>
                                <?php $traslados = $movimiento->getDocumento()->getTraslados(); $__data['traslados'] = $movimiento->getDocumento()->getTraslados(); ?>
                                <?php $trasladoIVA = 0; $__data['trasladoIVA'] = 0; ?>
                                <?php
app('blade.helpers')->get('loop')->newLoop($traslados);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $traslado):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <?php if($traslado['impuesto'] === 'IVA'): ?>
                                        <?php $trasladoIVA = $traslado['importe']; $__data['trasladoIVA'] = $traslado['importe']; ?>
                                    <?php endif; ?>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                <?php echo e($trasladoIVA); ?>

                            </td>
                            <td>
                                <?php $trasladoIEPS = 0; $__data['trasladoIEPS'] = 0; ?>
                                <?php
app('blade.helpers')->get('loop')->newLoop($traslados);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $traslado):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <?php if($traslado['impuesto'] === 'IEPS'): ?>
                                        <?php $trasladoIEPS = $traslado['importe']; $__data['trasladoIEPS'] = $traslado['importe']; ?>
                                    <?php endif; ?>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                <?php echo e($trasladoIEPS); ?>

                            </td>
                            <td><?php echo e($movimiento->getDeduccion()); ?></td>
                            <td><?php echo e($movimiento->getTipoGasto()); ?></td>
                            <td><?php echo e($movimiento->getClasificacion()); ?></td>
                            <td><?php echo e(number_format($movimiento->getMonto(), 2, '.', ',')); ?></td>
                        </tr>
                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                </tbody>
            </table>
        <?php else: ?>
            <h3>No se encontraron movimientos para ese periodo.</h3>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/limitless_14/generals.js'); ?>

<?php $__env->appendSection(); ?>
