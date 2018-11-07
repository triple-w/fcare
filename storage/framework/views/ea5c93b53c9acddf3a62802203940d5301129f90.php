<?php $__env->startSection('title', 'Documentos Periodo'); ?>

<?php $__env->startSection('content'); ?>

    <div id="modal-datos-pagado" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Pagado</h4>
          </div>
          <div class="modal-body">
                <div class="mensaje hide">Hubo un error al actualizar el registro.</div>
                <h3>Periodo: <?php echo e($periodo->getMes()); ?> - <?php echo e($periodo->getAnio()); ?></h3>
                <?php echo BootForm::open([ 'url' => action('Users\PeriodosController@postDocumentoPagado'), 'method' => 'POST', 'class' => 'documento-pagado' ]); ?>

                    <input type="hidden" class="documento-id" name="documento-id" value="">
                    <?php echo BootForm::select('deduccion', 'Deduccion', \App\Models\UsersPeriodosDocumentosPagos::getDeducciones(), null, [ 'class' => 'deduccion' ]); ?>

                    <?php echo BootForm::select('tipoGasto', 'Tipo de Gasto', \App\Models\UsersPeriodosDocumentosPagos::getTiposGastos(), null, [ 'class' => 'tipo-gasto' ]); ?>

                    <?php echo BootForm::select('clasificacion', 'Clasificacion', \App\Models\UsersPeriodosDocumentosPagos::getClasificaciones(), null, [ 'class' => 'clasificacion' ]); ?>

                    <?php echo BootForm::text('monto', 'Monto Pagado', '0', [ 'class' => 'monto-pagar' ]); ?>

                    <?php echo BootForm::submit('Aceptar'); ?>

                <?php echo BootForm::close(); ?>

          </div>
          <div class="modal-footer">
            <input type="hidden" id="href-eliminar" value="">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <!-- Basic tabs -->
            <div class="panel-body">
                <h3>Periodo: <?php echo e($periodo->getMes()); ?> - <?php echo e($periodo->getAnio()); ?></h3>
                <?php echo BootForm::open([ 'url' => action('Users\PeriodosController@postTerminar'), 'method' => 'POST' ]); ?>

                    <div class="row">
                        <input type="hidden" name="mes" value="<?php echo e($periodo->getMes()); ?>">
                        <input type="hidden" name="anio" value="<?php echo e($periodo->getAnio()); ?>">
                    </div>
                    <?php echo BootForm::submit('Terminar Periodo Actual');; ?>

                <?php echo BootForm::close();; ?>

            </div>
        </div>
    </div>

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <!-- Basic tabs -->
            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="<?php echo e($tipo === 'EMITIDO' ? 'active' : ''); ?>"><a href="#basic-tab1" data-toggle="tab">Ingresos</a></li>
                        <li class="<?php echo e($tipo === 'RECIBIDO' ? 'active' : ''); ?>"><a href="#basic-tab2" data-toggle="tab">Egresos</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane <?php echo e($tipo === 'EMITIDO' ? 'active' : ''); ?>" id="basic-tab1">
                            <h3>INGRESOS</h3>
                            <div class="margin-bottom-50">
                                <h3>Ingresos sin Factura: <?php echo e($periodo->getIngresoSinFactura()); ?></h3>
                                <div class="well">
                                    <?php echo BootForm::open([ 'url' => action('Users\PeriodosController@postUpdatePeriodo', [ 'id' => $periodo->getId() ]) ]); ?>

                                        <?php echo BootForm::text('ingresoSinFactura', 'Ingreso sin Factura', $periodo->getIngresoSinFactura(), []); ?>

                                        <?php echo BootForm::submit('Guardar');; ?>

                                    <?php echo BootForm::close();; ?>

                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>UUID</th>
                                                <th>Fecha Emisión</th>
                                                <th>RFC Emisor</th>
                                                <th>Nombre Emisor</th>
                                                <th>RFC Receptor</th>
                                                <th>Nombre Receptor</th>
                                                <th>Pagado</th>
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        <tbody>
                                            <?php
app('blade.helpers')->get('loop')->newLoop($emitidos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $documento):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                                <tr>
                                                    <td><?php echo e($documento->getDatos()['uuid']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['fechaEmision']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['rfcEmisor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['nombreEmisor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['rfcReceptor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['nombreReceptor']); ?></td>
                                                    <td>$<?php echo e(number_format($documento->getSumPagos(), 2, '.', ',')); ?></td>
                                                    <td><?php echo e($documento->getDatos()['total']); ?></td>
                                                    <td><?php echo e($documento->getTipo()); ?></td>
                                                    <td><?php echo e($documento->getEstatus()); ?></td>
                                                    <td>
                                                        <?php if($documento->getEstatus() !== \App\Models\UsersPeriodosDocumentos::PAGADO): ?>
                                                            <?php echo HTML::link('#', '<i class="icon-cash" aria-hidden="true"></i>', [ 'class' => 'btn btn-default fecha-pagado', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Pagar', 'data-toggle' => 'modal', 'data-target' => '#modal-datos-pagado', 'data-id' => $documento->getId() ]); ?>

                                                        <?php endif; ?>
                                                        <?php echo HTML::link(action('Users\PeriodosController@getDeleteDocumento', [ 'id' => $documento->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
                        </div>

                        <div class="tab-pane <?php echo e($tipo === 'RECIBIDO' ? 'active' : ''); ?>" id="basic-tab2">
                            <h3>EGRESOS</h3>
                            <div class="margin-bottom-50">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>UUID</th>
                                                <th>Fecha Emisión</th>
                                                <th>RFC Emisor</th>
                                                <th>Nombre Emisor</th>
                                                <th>RFC Receptor</th>
                                                <th>Nombre Receptor</th>
                                                <th>Pagado</th>
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        <tbody>
                                            <?php
app('blade.helpers')->get('loop')->newLoop($recibidos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $documento):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                                <tr>
                                                    <td><?php echo e($documento->getDatos()['uuid']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['fechaEmision']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['rfcEmisor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['nombreEmisor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['rfcReceptor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['nombreReceptor']); ?></td>
                                                    <td>$<?php echo e(number_format($documento->getSumPagos(), 2, '.', ',')); ?></td>
                                                    <td><?php echo e($documento->getDatos()['total']); ?></td>
                                                    <td><?php echo e($documento->getTipo()); ?></td>
                                                    <td><?php echo e($documento->getEstatus()); ?></td>
                                                    <td>
                                                        <?php if($documento->getEstatus() !== \App\Models\UsersPeriodosDocumentos::PAGADO): ?>
                                                            <?php echo HTML::link('#', '<i class="icon-cash" aria-hidden="true"></i>', [ 'class' => 'btn btn-default fecha-pagado', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Pagar', 'data-toggle' => 'modal', 'data-target' => '#modal-datos-pagado', 'data-id' => $documento->getId() ]); ?>

                                                        <?php endif; ?>
                                                        <?php echo HTML::link(action('Users\PeriodosController@getDeleteDocumento', [ 'id' => $documento->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
                        </div>

                    </div>
                </div>
            </div>
            <!-- /basic tabs -->
        </div>
    </div>

    <h3>MESES ANTERIORES</h3>
    <div class="panel panel-flat panel-collapsed">
        <div class="panel-heading">
            <h5 class="panel-title"></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <!-- Basic tabs -->
            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="<?php echo e($tipo === 'EMITIDO' ? 'active' : ''); ?>"><a href="#basic-tab3" data-toggle="tab">Ingresos</a></li>
                        <li class="<?php echo e($tipo === 'RECIBIDO' ? 'active' : ''); ?>"><a href="#basic-tab4" data-toggle="tab">Egresos</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane <?php echo e($tipo === 'EMITIDO' ? 'active' : ''); ?>" id="basic-tab3">
                            <h3>INGRESOS</h3>
                            <div class="margin-bottom-50">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>UUID</th>
                                                <th>Fecha Emisión</th>
                                                <th>RFC Emisor</th>
                                                <th>Nombre Emisor</th>
                                                <th>RFC Receptor</th>
                                                <th>Nombre Receptor</th>
                                                <th>Pagado</th>
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        <tbody>
                                            <?php
app('blade.helpers')->get('loop')->newLoop($emitidosAnteriores);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $documento):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                                <tr>
                                                    <td><?php echo e($documento->getDatos()['uuid']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['fechaEmision']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['rfcEmisor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['nombreEmisor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['rfcReceptor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['nombreReceptor']); ?></td>
                                                    <td>$<?php echo e(number_format($documento->getSumPagos(), 2, '.', ',')); ?></td>
                                                    <td><?php echo e($documento->getDatos()['total']); ?></td>
                                                    <td><?php echo e($documento->getTipo()); ?></td>
                                                    <td><?php echo e($documento->getEstatus()); ?></td>
                                                    <td>
                                                        <?php if($documento->getEstatus() !== \App\Models\UsersPeriodosDocumentos::PAGADO): ?>
                                                            <?php echo HTML::link('#', '<i class="icon-cash" aria-hidden="true"></i>', [ 'class' => 'btn btn-default fecha-pagado', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Pagar', 'data-toggle' => 'modal', 'data-target' => '#modal-datos-pagado', 'data-id' => $documento->getId() ]); ?>

                                                        <?php endif; ?>
                                                        <?php echo HTML::link(action('Users\PeriodosController@getDeleteDocumento', [ 'id' => $documento->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
                        </div>

                        <div class="tab-pane <?php echo e($tipo === 'RECIBIDO' ? 'active' : ''); ?>" id="basic-tab4">
                            <h3>EGRESOS</h3>
                            <div class="margin-bottom-50">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>UUID</th>
                                                <th>Fecha Emisión</th>
                                                <th>RFC Emisor</th>
                                                <th>Nombre Emisor</th>
                                                <th>RFC Receptor</th>
                                                <th>Nombre Receptor</th>
                                                <th>Pagado</th>
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        <tbody>
                                            <?php
app('blade.helpers')->get('loop')->newLoop($recibidosAnteriores);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $documento):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                                <tr>
                                                    <td><?php echo e($documento->getDatos()['uuid']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['fechaEmision']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['rfcEmisor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['nombreEmisor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['rfcReceptor']); ?></td>
                                                    <td><?php echo e($documento->getDatos()['nombreReceptor']); ?></td>
                                                    <td>$<?php echo e(number_format($documento->getSumPagos(), 2, '.', ',')); ?></td>
                                                    <td><?php echo e($documento->getDatos()['total']); ?></td>
                                                    <td><?php echo e($documento->getTipo()); ?></td>
                                                    <td><?php echo e($documento->getEstatus()); ?></td>
                                                    <td>
                                                        <?php if($documento->getEstatus() !== \App\Models\UsersPeriodosDocumentos::PAGADO): ?>
                                                            <?php echo HTML::link('#', '<i class="icon-cash" aria-hidden="true"></i>', [ 'class' => 'btn btn-default fecha-pagado', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Pagar', 'data-toggle' => 'modal', 'data-target' => '#modal-datos-pagado', 'data-id' => $documento->getId() ]); ?>

                                                        <?php endif; ?>
                                                        <?php echo HTML::link(action('Users\PeriodosController@getDeleteDocumento', [ 'id' => $documento->getid() ]), '<i class="icon-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
                        </div>

                    </div>
                </div>
            </div>
            <!-- /basic tabs -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js'); ?>

    <?php echo HTML::scriptLocal('webroot/js/limitless_14/generals.js'); ?>

    <?php echo HTML::scriptLocal('webroot/js/limitless_14/periodos_edit.js?v=1.0.0'); ?>

<?php $__env->appendSection(); ?>
