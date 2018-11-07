
<?php $__env->startSection('title', 'Transferir Timbres'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open();; ?>

    	<?php $usuarios = []; $__data['usuarios'] = []; ?>
    	<?php
app('blade.helpers')->get('loop')->newLoop(\App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO' ]));
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $usuario):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
    		<?php $usuarios[$usuario->getId()] = $usuario->getUsername(); $__data['usuarios[$usuario->getId()]'] = $usuario->getUsername(); ?>
    	<?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
    	<?php echo BootForm::select('userTransferencia', 'Usuario', $usuarios, [], []); ?>

        <?php echo BootForm::text('numeroTimbres', 'Numero de timbres', null, []); ?>

        <?php echo BootForm::submit('Aceptar');; ?>

    <?php echo BootForm::close();; ?>


<?php $__env->stopSection(); ?>