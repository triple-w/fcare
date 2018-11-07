
@section('title', 'Recuperar Password')

@section('scripts')
    {!! HTML::script('assets/js/plugins/forms/styling/uniform.min.js') !!}
    {!! HTML::script('assets/js/pages/login.js') !!}
@append

@section('class_body', 'login-container')
@set('background', asset('webroot/img/accounting_background.jpg'))
@section('style_body', "background-image: url('{$background}'); background-position: center;")

@section('content')
    <style type="text/css">
        .m-login__wrapper{
            overflow: hidden;
            padding: 2rem 2rem 2rem 2rem;
            background-color: #fff;
            margin-top: 6%;
            border-radius: 2%;
            margin-left: 33.33%;
        }
        @media(max-width: 768px){
            .m-login__wrapper{
                margin-top: 25%;
                margin-left: 0%;
            }
        }
    </style>
    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="m-login__wrapper col-md-4 col-md-offset-4" align="center">

                    <img src="{{ asset('webroot/img/logofactu.png') }}" class="img img-logo img-login" style="    margin-bottom: 10%;">

                    @include('flash::message')
                    <form role="form"  method="POST" action="{{ action('Users\AccountsController@postRecoveryEmail') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                                <h5 class="content-group">Recuperacion de Password <small class="display-block">Todos los campos son requeridos</small></h5>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="text" name="username" class="form-control" placeholder="RFC">
                                <div class="form-control-feedback">
                                    <i class="icon-user-check text-muted"></i>
                                </div>
                                <!-- <span class="help&#45;block text&#45;danger"><i class="icon&#45;cancel&#45;circle2 position&#45;left"></i> This username is already taken</span> -->
                            </div>

                            <button type="submit" class="btn bg-pink-400 btn-block btn-lg">Recuperar Contraseña <i class="icon-circle-right2 position-right"></i></button>
                            {!! HTML::link('auth/login', 'Login', [ 'class' => 'pull-right' ]) !!}
                        </div>
                    </form>

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