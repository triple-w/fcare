<?php $__env->startSection('title', 'Plantillas'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(!Auth::user()->getPlantillaPDF()): ?>
        <?php echo HTML::link(action('Users\PlantillasController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Seleccionar Plantilla', [ 'class' => 'btn btn-default' ]); ?>

    <?php endif; ?>

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Plantilla</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(Auth::user()->getPlantillaPDF()): ?>
                        <tr>
                            <td><?php echo e($Plantillas->getPlantillaPDF()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\PlantillasController@getEdit', [ 'id' => $Plantillas->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]); ?>

                                <?php echo HTML::link(action('Users\PlantillasController@getDelete', [ 'id' => $Plantillas->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/limitless_14/generals.js'); ?>

<?php $__env->appendSection(); ?>
