
<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>

    <h2>Transferencias</h2>
    <?php if(Auth::user()->getId() == 1): ?>
        <?php $transferencias = \App\Models\TimbresMovs::findBy([ 'tipo' => \App\Models\TimbresMovs::TRANSFERENCIA ]); $__data['transferencias'] = \App\Models\TimbresMovs::findBy([ 'tipo' => \App\Models\TimbresMovs::TRANSFERENCIA ]); ?>
    <?php else: ?>
        <?php $transferencias = \App\Models\TimbresMovs::findBy([ 'tipo' => \App\Models\TimbresMovs::TRANSFERENCIA, 'user' => Auth::user()->getId() ]); $__data['transferencias'] = \App\Models\TimbresMovs::findBy([ 'tipo' => \App\Models\TimbresMovs::TRANSFERENCIA, 'user' => Auth::user()->getId() ]); ?>
    <?php endif; ?>
        
    <table class="table datatable-pagination" datatable>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Timbres</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
app('blade.helpers')->get('loop')->newLoop($transferencias);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $transferencia):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                <tr>
                    <td><?php echo e($transferencia->getUserTransferencia()->getUsername()); ?></td>
                    <td><?php echo e($transferencia->getNumeroTimbres()); ?></td>
                    <td><?php echo e($transferencia->getFecha()->format('Y-m-d H:i:s')); ?></td>
                </tr>
            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
        </tbody>
    </table>

    <h2>Timbres por usuario</h2>
    <?php if(Auth::user()->getId() == 1): ?>
        <?php $users = \App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO' ]); $__data['users'] = \App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO' ]); ?>
    <?php else: ?>
        <?php $users = \App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO', 'admin' => Auth::user()->getId() ]); $__data['users'] = \App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO', 'admin' => Auth::user()->getId() ]); ?>
    <?php endif; ?>
    
    <table class="table datatable-pagination" datatable>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Timbres</th>
            </tr>
        </thead>
        <tbody>
            <?php
app('blade.helpers')->get('loop')->newLoop($users);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $user):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                <tr>
                    <td><?php echo e($user->getUsername()); ?></td>
                    <td><?php echo e($user->getTimbresDisponibles()); ?></td>
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