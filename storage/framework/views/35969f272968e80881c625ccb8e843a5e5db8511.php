
<?php $__env->startSection('title', 'Periodos'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(empty(Auth::user()->getPerfil()->getCiec())): ?>
        <?php echo Alert::danger('No existe un ciec configurado, porfavor ingresalo para poder continuar'); ?>

    <?php else: ?>
        <?php echo Alert::info('Si deseas cambiar tu CIEC solo ingresalo nuevamente'); ?>

    <?php endif; ?>
    <?php echo BootForm::open([ 'url' => action('Users\PeriodosController@postChangeCiec'), 'method' => 'POST' ]); ?>

        <?php echo BootForm::password('ciec', 'CIEC', []); ?>

        <?php echo BootForm::submit('Aceptar'); ?>

    <?php echo BootForm::close(); ?>


    <?php echo HTML::link(action('Users\PeriodosController@getTerminar'), '<i class="icon-plus2" aria-hidden="true"></i> Terminar Periodo', [ 'class' => 'btn btn-default' ]); ?>


    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-hover nowrap" id="example1" width="100%" datatable>
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Emitidos</th>
                        <th>Recibidos</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($periodos);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $periodo):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($periodo->getMes()); ?> - <?php echo e($periodo->getAnio()); ?></td>
                            <td><?php echo e(count(\App\Models\UsersPeriodosDocumentos::getEmitidos($periodo))); ?></td>
                            <td><?php echo e(count(\App\Models\UsersPeriodosDocumentos::getRecibidos($periodo))); ?></td>
                            <td><?php echo e($periodo->getEstatus()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\PeriodosController@getEdit', [ 'id' => $periodo->getid() ]), '<i class="icon-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]); ?>

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

<?php $__env->appendSection(); ?>
