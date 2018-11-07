
<?php $__env->startSection('title', 'Editar Datos'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo BootForm::open([ 'files' => true ]); ?>

        <?php echo BootForm::text('password', 'Password', $infoFactura->getPassword(), []); ?>

        <?php if(!empty($user->getInfoFactura()) && !empty($user->getInfoFactura()->getDocumentByType('ARCHIVO_CERTIFICADO'))): ?>
            <?php echo Label::success('Archivo de ceritifcado cargado correctamente'); ?>

            <?php if($user->getInfoFactura()->getDocumentByType('ARCHIVO_CERTIFICADO')->getRevisado()): ?>
                <?php echo Label::success('Revisado'); ?>

            <?php else: ?>
                <?php echo Label::danger('No revisado'); ?>

            <?php endif; ?>
            <?php if($user->getInfoFactura()->getDocumentByType('ARCHIVO_CERTIFICADO')->getValidado()): ?>
                <?php echo Label::success('Validado correctamente'); ?>

            <?php else: ?>
                <?php echo Label::danger('No validado'); ?>

            <?php endif; ?>
            <?php echo HTML::link(action('Users\AccountsController@getBorrarDocumento', [ 'id' => $user->getInfoFactura()->getDocumentByType('ARCHIVO_CERTIFICADO')->getId() ]), 'Eliminar Documento', [ 'class' => 'btn btn-danger' ]); ?>

            <br />
            <br />
        <?php else: ?>
            <?php echo BootForm::file('archivoCertificado', 'Archivo de certificado', [ 'accept' => '.cer' ]); ?>

        <?php endif; ?>

        <?php if(!empty($user->getInfoFactura()) && !empty($user->getInfoFactura()->getDocumentByType('ARCHIVO_LLAVE'))): ?>
            <?php echo Label::success('Archivo de llave cargado correctamente'); ?>

            <?php if($user->getInfoFactura()->getDocumentByType('ARCHIVO_LLAVE')->getRevisado()): ?>
                <?php echo Label::success('Revisado'); ?>

            <?php else: ?>
                <?php echo Label::danger('No revisado'); ?>

            <?php endif; ?>
            <?php if($user->getInfoFactura()->getDocumentByType('ARCHIVO_LLAVE')->getValidado()): ?>
                <?php echo Label::success('Validado correctamente'); ?>

            <?php else: ?>
                <?php echo Label::danger('No validado'); ?>

            <?php endif; ?>
            <?php echo HTML::link(action('Users\AccountsController@getBorrarDocumento', [ 'id' => $user->getInfoFactura()->getDocumentByType('ARCHIVO_LLAVE')->getId() ]), 'Eliminar Documento', [ 'class' => 'btn btn-danger' ]); ?>

        <?php else: ?>
            <?php echo BootForm::file('archivoLlave', 'Archivo de llave', [ 'accept' => '.key' ]); ?>

        <?php endif; ?>
        <?php echo BootForm::submit('Agregar'); ?>

    <?php echo BootForm::close(); ?>


<?php $__env->stopSection(); ?>
