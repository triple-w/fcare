@section('title', 'Registrarse')

@section('scripts')
    {!! HTML::script('assets/vendors/custom/wizards/stepy.min.js') !!}
@append

@section('class_body', 'm--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default')

@section('content')
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-3.jpg);">
        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="https://tuconta.online">
                        <img src="{{ asset('webroot/img/logofactu.png') }}" class="img img-logo img-login" style="width: 80%">
                    </a>
                </div>
                <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">
                                Registro
                            </h3>
                            @include('flash::message')
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
                    {!! BootForm::open([ 'role' => 'form', 'class' => 'm-login__form m-form', 'onsubmit' => 'return validacion()' ]) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" id="RFC" type="text" placeholder="RFC" name="username" autocomplete="off">
                            @if ($errors->has('username'))
                                @foreach ($errors->get('username') as $message)
                                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $message }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" id="email" type="email" placeholder="Email" name="email">
                            @if ($errors->has('email'))
                                @foreach ($errors->get('email') as $message)
                                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $message }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" id="password" type="password" placeholder="Password" name="password">
                            @if ($errors->has('password'))
                                @foreach ($errors->get('password') as $message)
                                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $message }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" id="confirmation" type="password" placeholder="Confirmacion de Password" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                @foreach ($errors->get('password_confirmation') as $message)
                                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $message }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" id="admin"  type="text" placeholder="¿Quién es tu admin?" name="admin" autocomplete="off">
                            <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i></span>
                        </div>

                        {!! Recaptcha::render() !!}
                        

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
                    {!! HTML::link('auth/login', 'Inicia sesión', [ 'class' => 'm-link m-link--light m-login__account-link' ]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
@endsection

@section('scripts')
    {!! HTML::scriptLocal('webroot/js/validateRFC.js') !!}
@append