<?php $__env->startSection('title', 'Registrarse'); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::script('assets/vendors/custom/wizards/stepy.min.js'); ?>

<?php $__env->appendSection(); ?>

<?php $__env->startSection('class_body', 'm--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default'); ?>

<?php $__env->startSection('content'); ?>
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-3.jpg);">
        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="https://tuconta.online">
                        <img src="<?php echo e(asset('webroot/img/logofactu.png')); ?>" class="img img-logo img-login" style="width: 80%">
                    </a>
                </div>
                <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">
                                Registro
                            </h3>
                        </div>
                   <!-- <div class="well">
                        <ul id="stepy-004826721065003481-header" class="stepy-header">
                            <li id="stepy-004826721065003481-head-0" class="stepy-active" style="cursor: default;">
                                <div>1</div><span>Datos de usuario</span></li><li id="stepy-004826721065003481-head-0" style="cursor: default;">
                            </li>
                            <li id="stepy-004826721065003481-head-1" style="cursor: default;">
                                <div>2</div><span>Datos de Pago</span></li><li id="stepy-004826721065003481-head-1" style="cursor: default;">
                            </li>
                            <li id="stepy-004826721065003481-head-2" style="cursor: default;">
                                <div>3</div><span>Datos de perfil</span></li><li id="stepy-004826721065003481-head-2" style="cursor: default;">
                            </li>
                        </ul>
                    </div>-->
                    <?php echo BootForm::open([ 'role' => 'form', 'class' => 'm-login__form m-form' ]); ?>

                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"/>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input"   type="text" placeholder="RFC" name="username" autocomplete="off">
                            <?php if($errors->has('username')): ?>
                                <?php
app('blade.helpers')->get('loop')->newLoop($errors->get('username'));
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $message):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> <?php echo e($message); ?></span>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                            <?php endif; ?>
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="email" placeholder="Email" name="email">
                            <?php if($errors->has('email')): ?>
                                <?php
app('blade.helpers')->get('loop')->newLoop($errors->get('email'));
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $message):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> <?php echo e($message); ?></span>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                            <?php endif; ?>
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                            <?php if($errors->has('password')): ?>
                                <?php
app('blade.helpers')->get('loop')->newLoop($errors->get('password'));
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $message):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> <?php echo e($message); ?></span>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                            <?php endif; ?>
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirmacion de Password" name="password_confirmation">
                            <?php if($errors->has('password_confirmation')): ?>
                                <?php
app('blade.helpers')->get('loop')->newLoop($errors->get('password_confirmation'));
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $message):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> <?php echo e($message); ?></span>
                                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                            <?php endif; ?>
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input"   type="text" placeholder="¿Quién es tu admin?" name="admin" autocomplete="off">
                            <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i></span>
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Registrarse
                            </button>
                        </div>
                    </form>
                </div>
                <div class="m-login__account">
                    <span class="m-login__account-msg">
                        ¿Ya tienes una cuenta?
                    </span>
                    &nbsp;&nbsp;
                    <?php echo HTML::link('auth/login', 'Inicia sesión', [ 'class' => 'm-link m-link--light m-login__account-link' ]); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
<?php $__env->stopSection(); ?>