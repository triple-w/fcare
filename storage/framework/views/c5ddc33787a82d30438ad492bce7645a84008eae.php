<?php $__env->startSection('title', 'Editar Usuario'); ?>

<?php $__env->startSection('content'); ?>

<div id="modal-borrar-user" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Usuario</h4>
            </div>
            <div class="modal-body">
            <p>¿Estás seguro de eliminar el usuario <strong> <?php echo e($user->getUsername()); ?> </strong>? Esta operación <strong>NO</strong> se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <?php echo HTML::link(action('Users\AccountsController@getBorrarUsuario', [ 'id' => $user->getId() ]), 'Eliminar', ['class' => 'btn btn-danger' ]); ?>

                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <?php echo HTML::link(action('Users\AccountsController@getIndex'), 'Regresar', [ 'class' => 'btn btn-default', 'icon' => 'arrow-left' ]); ?>


    <?php echo BootForm::open();; ?>


        <?php /* FIX Check When Action is Edit */ ?>
        <?php if(empty($user->getId())): ?>
            <?php echo BootForm::email('email', 'Email', $user->getEmail(), ['required' => 'required']);; ?>

            <?php echo BootForm::text('username', 'Username', $user->getUsername(), ['required' => 'required']);; ?>

        <?php endif; ?>

        <?php /* FIX Check When Action is Edit */ ?>
        <?php if(empty($user->getId())): ?>
            <?php echo BootForm::password('password', 'Password', ['required' => 'required']);; ?>

            <?php echo BootForm::password('password_confirmation', 'Password Confirm', ['required' => 'required']);; ?>

        <?php else: ?>
        <div class="row">
            <div class="col-md-12">
                <h2>Usuario</h2>
            </div>
            <?php $perfil = $user->getPerfil() ?>
            <div class="col-md-4">
                <p><strong>Usuario:</strong> <?php echo e($user->getUsername()); ?></p>
                <p><strong>Email: </strong> <?php echo e($user->getEmail()); ?> - <a href="mailto: <?php echo e($user->getEmail()); ?>">Escribir email</a></p>
            </div>
            <div class="col-md-4">
                <p><strong>Rol: </strong> <?php echo e($user->getRol()); ?></p>
                <?php if($user->getVerified()): ?>
                    <?php echo Label::success('Verificado'); ?>

                <?php else: ?>
                    <?php echo Label::danger('No verificado'); ?>

                <?php endif; ?>
                <?php if($user->getActive()): ?>
                    <?php echo Label::success('Activo'); ?>

                <?php else: ?>
                    <?php echo Label::danger('No activo'); ?>

                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <p><strong>Último inicio de sesión: </strong> <?php echo e($user->getLastLogin()); ?></p>
            </div>
        </div>
        <?php endif; ?>
        <?php if($user->getRol() !== 'ROLE_USUARIO' && Auth::user()->getUsername() === 'admin'): ?>
            <?php echo BootForm::checkboxes('permisos[]', 'Permisos', \App\Models\Users::getListPermisos(), $user->getPermisos(), []); ?>

        <?php endif; ?>

        <?php echo BootForm::checkbox('active', 'Activo', '1', $user->getActive());; ?>

        <?php echo BootForm::submit('Guardar');; ?>

    <?php echo BootForm::close();; ?>


    <div class="row">
        <div class="col-md-12">
            <h2>Detalles</h2>
        </div>
        <div class="col-md-4">
            <p><strong>RFC: </strong> <?php echo e($perfil->getRfc()); ?></p>
            <p><strong>Razón social: </strong> <?php echo e($perfil->getRazonSocial()); ?></p>
            <p><strong>Calle: </strong> <?php echo e($perfil->getCalle()); ?></p>
            <p><strong>Número exterior: </strong> <?php echo e($perfil->getNoExt()); ?></p>
            <p><strong>Número interior: </strong> <?php echo e($perfil->getNoInt()); ?></p>
        </div>
        <div class="col-md-4">
            <p><strong>Colonia: </strong> <?php echo e($perfil->getColonia()); ?></p>
            <p><strong>Municipio: </strong> <?php echo e($perfil->getMunicipio()); ?></p>
            <p><strong>Localidad: </strong> <?php echo e($perfil->getLocalidad()); ?></p>
            <p><strong>Estado: </strong> <?php echo e($perfil->getEstado()); ?></p>
            <p><strong>Código postal: </strong> <?php echo e($perfil->getCodigoPostal()); ?></p>
        </div>
        <div class="col-md-4">
            <p><strong>País: </strong> <?php echo e($perfil->getPais()); ?></p>
            <p><strong>Teléfono: </strong> <?php echo e($perfil->getTelefono()); ?>

                <?php if(!empty($perfil->getTelefono())): ?>
                 - <a href="tel: <?php echo e($perfil->getTelefono()); ?>">Llamar</a>
                <?php endif; ?>
                </p>
            <p><strong>Nombre de contacto: </strong> <?php echo e($perfil->getNombreContacto()); ?></p>
            <p><strong>CIEC: </strong> <?php echo e($perfil->getCiec()); ?></p>
            <p><strong>Régimen: </strong> <?php echo e($perfil->getNombreRegimen()); ?></p>
        </div>
    </div>
    <br>

    <?php if($user->getRol() === 'ROLE_USUARIO'): ?>
        <div class="row" id="usersAcciones">
            <div class="col-md-12">
                <h2>Acciones</h2>
            </div>
            <?php if(!empty($user->getInfoFactura())): ?>
                <div class="col-sm-2">
                    <?php echo HTML::link(action('Users\AccountsController@getDocumentos', [ 'id' => $user->getId() ]), 'Documentos', ['class' => 'btn btn-default' ]); ?>

                </div>
            <?php endif; ?>
            <div class="col-sm-2">
                <?php echo HTML::link(action('Users\AccountsController@getPeriodos', [ 'id' => $user->getId() ]), 'Periodos', ['class' => 'btn btn-default' ]); ?>

            </div>
            <div class="col-sm-2">
                <?php echo HTML::link(action('Users\AccountsController@getPeriodosTerminados', [ 'id' => $user->getId() ]), 'Periodos Terminados', ['class' => 'btn btn-default' ]); ?>

            </div>
            <div class="col-sm-2">
                <?php echo HTML::link(action('Users\AccountsController@getSolicitudesPeriodos', [ 'id' => $user->getId() ]), 'Solicitudes Periodos', ['class' => 'btn btn-default' ]); ?>

            </div>
            <div class="col-sm-2">
                <?php echo HTML::link(action('Users\PeriodosMovimientosController@getBusquedaAdmin', [ 'id' => $user->getId() ]), 'Movimientos', ['class' => 'btn btn-default' ]); ?>

            </div>
            <div class="col-sm-2">
                <?php echo HTML::link(action('Users\PeriodosMovimientosPropuestasController@getIndexAdmin', [ 'id' => $user->getId() ]), 'Declaraciones', ['class' => 'btn btn-default' ]); ?>

            </div>
            <?php if(!$user->getVerified()): ?>
                <div class="col-sm-2">
                    <?php echo HTML::link(action('Users\AccountsController@getVerificate', [ 'id' => $user->getId() ]), 'Verificar', ['class' => 'btn btn-default' ]); ?>

                    <?php echo HTML::link(action('Users\AccountsController@getForwardEmail', [ 'id' => $user->getId() ]), 'Reenvio de correo', ['class' => 'btn btn-default' ]); ?>

                </div>
            <?php endif; ?>
            <div class="col-sm-2">
                <a href="#" id="btn-borrar-user" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    <?php endif; ?>

    <script>
        $('#btn-borrar-user').click(function(e){
            e.preventDefault();
            $('#modal-borrar-user').modal('show');
        });
    </script>

<?php $__env->stopSection(); ?>