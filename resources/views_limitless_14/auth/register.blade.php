
@section('title', 'Registrarse')

@section('scripts')
    {!! HTML::script('assets/js/plugins/forms/styling/uniform.min.js') !!}
    {!! HTML::script('assets/js/pages/login.js') !!}
    {!! HTML::script('assets/js/plugins/forms/wizards/stepy.min.js') !!}
@append

@section('class_body', 'login-container')
@set('background', asset('webroot/img/accounting_background.jpg'))
@section('style_body', "background-image: url('{$background}'); background-position: center;")

@section('content')

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">
                    <div class="well">
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
                    </div>
                    <br />
                    <br />
                    <br />

                    <!-- Advanced login -->
                    {!! BootForm::open([ 'role' => 'form' ]) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                                <h5 class="content-group">Crear Cuenta<small class="display-block">Todos los campos son requeridos</small></h5>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="text" name="username" class="form-control" placeholder="RFC">
                                <div class="form-control-feedback">
                                    <i class="icon-user-check text-muted"></i>
                                </div>
                                @if ($errors->has('username'))
                                    @foreach ($errors->get('username') as $message)
                                        <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $message }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="text" name="email" class="form-control" placeholder="Email">
                                <div class="form-control-feedback">
                                    <i class="icon-user-check text-muted"></i>
                                </div>
                                @if ($errors->has('email'))
                                    @foreach ($errors->get('email') as $message)
                                        <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $message }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <div class="form-control-feedback">
                                    <i class="icon-user-lock text-muted"></i>
                                </div>
                                @if ($errors->has('password'))
                                    @foreach ($errors->get('password') as $message)
                                        <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $message }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmacion de Password">
                                <div class="form-control-feedback">
                                    <i class="icon-user-lock text-muted"></i>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    @foreach ($errors->get('password_confirmation') as $message)
                                        <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $message }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <!-- <div class="content&#45;divider text&#45;muted form&#45;group"><span>Your privacy</span></div> -->

                            <!-- <div class="content&#45;divider text&#45;muted form&#45;group"><span>Additions</span></div> -->

                            <!-- <div class="form&#45;group"> -->
                            <!--     <div class="checkbox"> -->
                            <!--         <label> -->
                            <!--             <input type="checkbox" class="styled" checked="checked"> -->
                            <!--             Send me <a href="#">test account settings</a> -->
                            <!--         </label> -->
                            <!--     </div> -->
                            <!--  -->
                            <!--     <div class="checkbox"> -->
                            <!--         <label> -->
                            <!--             <input type="checkbox" class="styled" checked="checked"> -->
                            <!--             Subscribe to monthly newsletter -->
                            <!--         </label> -->
                            <!--     </div> -->
                            <!--  -->
                            <!--     <div class="checkbox"> -->
                            <!--         <label> -->
                            <!--             <input type="checkbox" class="styled"> -->
                            <!--             Accept <a href="#">terms of service</a> -->
                            <!--         </label> -->
                            <!--     </div> -->
                            <!-- </div> -->

                            <button type="submit" class="btn bg-pink-400 btn-block btn-lg">Registrarse <i class="icon-circle-right2 position-right"></i></button>
                            {!! HTML::link('auth/login', 'Login', [ 'class' => 'pull-right' ]) !!}
                        </div>
                    </form>
                    <!-- /advanced login -->


                    <!-- Footer -->
                    <div class="footer text-muted text-center">
                        <!-- &#38;copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a> -->
                    </div>
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->

@endsection