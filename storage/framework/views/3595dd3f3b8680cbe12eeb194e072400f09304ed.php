
<?php $__env->startSection('title', 'Inicio'); ?>

<?php $__env->startSection('content'); ?>

<div class="m-portlet">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-xl-4">
                    <!--begin:: Widgets/Profit Share-->
                    <div class="m-widget14">
                        <?php $cfdiEsteMes = \App\Models\Facturas::getGeneradosEsteMes(); $__data['cfdiEsteMes'] = \App\Models\Facturas::getGeneradosEsteMes(); ?>
                        <?php $cfdiEsteMes = $cfdiEsteMes += \App\Models\Nominas::getGeneradosEsteMes(); $__data['cfdiEsteMes'] = $cfdiEsteMes += \App\Models\Nominas::getGeneradosEsteMes(); ?>
                        <div class="m-widget14__header">
                            <h3 class="m-widget14__title">
                                CFDI´s
                            </h3>
                            <span class="m-widget14__desc">
                                Generados éste mes
                            </span>
                        </div>
                        <div class="row  align-items-center">
                            <div class="col">
                                <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 30px">
                                    <div class="m-widget14__stat">
                                            <?php echo e($cfdiEsteMes); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget14__header">
                            <h3 class="m-widget14__title">
                                Timbres
                            </h3>
                            <span class="m-widget14__desc">
                                Timbres disponibles
                            </span>
                        </div>
                        <div class="row  align-items-center">
                            <div class="col">
                                <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 30px">
                                    <div class="m-widget14__stat">
                                            <?php echo e(Auth::user()->getTimbresDisponibles()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Profit Share-->
                </div>
                <div class="col-xl-4">
                    <!--begin:: Widgets/Profit Share-->
                    <div class="m-widget14">
                        <div class="m-widget14__header">
                            <h3 class="m-widget14__title">Iniciar</h3>
                            <span class="m-widget14__desc">
                                Accesos rápidos
                            </span>
                            <div class="m-nav-grid m-nav-grid--skin-light">
                                <div class="m-nav-grid__row">
                                    <a href="<?php echo e(action('Users\FacturasV33Controller@getAdd')); ?>" class="m-nav-grid__item">
                                        <i class="m-nav-grid__icon flaticon-file"></i>
                                        <span class="m-nav-grid__text">
                                            Generar factura
                                        </span>
                                    </a>
                                    <a href="<?php echo e(action('Users\ComplementosV33Controller@getAdd')); ?>" class="m-nav-grid__item">
                                        <i class="m-nav-grid__icon flaticon-clipboard"></i>
                                        <span class="m-nav-grid__text">
                                            Generar complemento de pago
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Profit Share-->
                </div>
                <div class="col-xl-4">
                    <!--begin:: Widgets/Support Stats-->
                    <div class="m-widget1">
                        <div class="m-widget1__item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">
                                        Completar Perfil:
                                    </h3>
                                    <span class="m-widget1__desc">
                                        <?php if(Auth::user()->getCompletarPerfil()): ?>
                                            Tu perfil está completo
                                            <?php $icono = '<i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i>'; $__data['icono'] = '<i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i>'; ?>
                                        <?php else: ?>
                                            Actualiza tu perfil <a href="<?php echo e(action('Users\AccountsController@getPerfil')); ?>">aquí</a>
                                            <?php $icono = '<i class="fa fa-check-circle" style="color:red" aria-hidden="true"></i>'; $__data['icono'] = '<i class="fa fa-check-circle" style="color:red" aria-hidden="true"></i>'; ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-accent">
                                        <?php echo $icono; ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget1__item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">
                                        Sellos digitales
                                    </h3>
                                    <span class="m-widget1__desc">

                                        <?php if(Auth::user()->getFolios()): ?>
                                            Tus datos de pago son válidos
                                            <?php $icono = '<i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i>'; $__data['icono'] = '<i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i>'; ?>
                                        <?php else: ?>
                                            Actualiza tus datos de pago <a href="<?php echo e(action('Pagos\ContabilidadController@getPago')); ?>">aquí</a>
                                            <?php $icono = '<i class="fa fa-check-circle" style="color:red" aria-hidden="true"></i>'; $__data['icono'] = '<i class="fa fa-check-circle" style="color:red" aria-hidden="true"></i>'; ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-info">
                                        <?php echo $icono; ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget1__item">
                            <h3 class="m-widget1__title">
                                Folios
                            </h3>
                            <?php
app('blade.helpers')->get('loop')->newLoop($folios);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $folio):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">                
                                    <span class="m-widget1__desc">                                        
                                            <?php echo e($folio->getTipo()); ?>

                                            <?php $icono = '<i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i>'; $__data['icono'] = '<i class="fa fa-check-circle" style="color:green" aria-hidden="true"></i>'; ?>
                                    </span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-info">
                                        <?php echo $icono; ?>

                                        <br>
                                    </span>
                                </div>
                            </div>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                            <?php
app('blade.helpers')->get('loop')->newLoop($foliosf);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $folio):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">                
                                    <span class="m-widget1__desc">                                        
                                            <?php echo e($folio); ?><br>
                                            Agrega el folio <a href="<?php echo e(action('Users\FoliosController@getAdd')); ?>">aquí</a>
                                            <?php $icono = '<i class="fa fa-check-circle" style="color:red" aria-hidden="true"></i>'; $__data['icono'] = '<i class="fa fa-check-circle" style="color:red" aria-hidden="true"></i>'; ?>
                                    </span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-info">
                                        <?php echo $icono; ?>

                                        <br>
                                    </span>
                                </div>
                            </div>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        </div>
                    </div>
                    <!--end:: Widgets/Support Stats-->
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/limitless_14/dashboard.js?v=1.0.0'); ?>

<?php $__env->appendSection(); ?>
