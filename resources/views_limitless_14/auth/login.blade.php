
@section('title', 'Login')

@section('class_body', '"m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default')

@section('content')

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
            <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
                <div class="m-stack m-stack--hor m-stack--desktop">
                    <div class="m-stack__item m-stack__item--fluid">
                        <div class="m-login__wrapper">
                            <div class="m-login__logo">
                                <a href="https://tuconta.online">
                                    <img src="{{ asset('webroot/img/logofactu.png') }}" class="img img-logo img-login">
                                </a>
                            </div>
                            <div class="m-login__signin">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">
                                        Inicia Sesión
                                    </h3>
                                    @include('flash::message')
                                    @if ($errors->first('email_username'))
                                        {!! Alert::danger(
                                            HTML::icon('exclamation-circle') . ' ' . $errors->first('email_username'))
                                            ->close()
                                        !!}
                                    @endif
                                </div>
                                {!! BootForm::open([ 'action' => 'Auth\AuthController@postLogin', 'class' => 'm-login__form m-form' ]) !!}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input" type="text" placeholder="RFC" name="email_username" autocomplete="on">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                                    </div>
                                    <div class="row m-login__form-sub">
                                        <div class="col m--align-center">
                                                {!! HTML::link(action('Users\AccountsController@getRecoveryEmail'), 'Recuperar Contraseña', [ 'class' => 'm-link' ]) !!}
                                        </div>
                                    </div>
                                    <div class="m-login__form-action">
                                        <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                            Log In
                                        </button>
                                    </div>
                                {!! BootForm::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="m-stack__item m-stack__item--center">
                        <div class="m-login__account">
                            <span class="m-login__account-msg">
                                ¿Aún no tienes cuenta?
                            </span>
                            &nbsp;&nbsp;
                            {!! HTML::link(action('Users\AccountsController@getRegister'), 'Crea una', [ 'class' => 'm-link m-link--focus m-login__account-link' ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url('{{ asset('/webroot/themes/metronic-52/dist/demo5/assets/app/media/img/bg/bg-5.jpg') }}')">
                <div class="m-grid__item m-grid__item--middle">
                    <h3 class="m-login__welcome">
                        La mejor solución contable
                    </h3>
                    <p class="m-login__msg">
                        En Factucare te ayudamos para que la contabilidad como la conocemos parezca cosa del pasado,
                        <br> olvídate de los finales de mes pidiendo que te envíen las facturas. 
                        <br>
                        <br>El futuro de la contabilidad es Factucare
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Page -->

@endsection