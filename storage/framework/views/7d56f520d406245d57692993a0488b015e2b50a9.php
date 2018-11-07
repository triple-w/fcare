
<?php $__env->startSection('title', 'Folios'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(!empty(\App\Models\Folios::getDiffFolios(Auth::user(), \App\Models\Folios::getTiposFolio()))): ?>
        <?php echo HTML::link(action('Users\FoliosController@getAdd'), '<i class="icmn-plus2" aria-hidden="true"></i> Nuevo Folio', [ 'class' => 'btn btn-default' ]); ?>

    <?php endif; ?>

    <br />
    <br />

    <div class="margin-bottom-50">
        <div class="table-responsive">
            <table class="table" datatable>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
app('blade.helpers')->get('loop')->newLoop($folios);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $folio):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <tr>
                            <td><?php echo e($folio->getTipo()); ?></td>
                            <td><?php echo e($folio->getSerie()); ?></td>
                            <td><?php echo e($folio->getFolio()); ?></td>
                            <td>
                                <?php echo HTML::link(action('Users\FoliosController@getEdit', [ 'id' => $folio->getid() ]), '<i class="icmn-pencil5" aria-hidden="true"></i>', [ 'class' => 'btn btn-default', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Editar' ]); ?>

                                <?php echo HTML::link(action('Users\FoliosController@getDelete', [ 'id' => $folio->getid() ]), '<i class="icmn-cross" aria-hidden="true"></i>', [ 'class' => 'btn btn-danger eliminar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Eliminar' ]); ?>

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
