<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="csrf-token" value="{{ csrf_token() }}" />
    <meta id="url-public" value="{{ asset('') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/webroot/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/webroot/img/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/webroot/img/favicon/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('/webroot/img/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- HTML5 shim and Respond.js for < IE9 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
        });
    </script>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    {!! HTML::style('assets/vendors/base/vendors.bundle.css') !!}
    {!! HTML::style('assets/demo/demo5/base/style.bundle.css') !!}
    
    <!-- /global stylesheets -->
    {!! HTML::styleLocal('webroot/css/main.css') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/fonts.css') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/select2.css') !!}
    {!! HTML::styleLocal('webroot/themes/clean-ui/datatables-responsive.css') !!}
    <!--{!! HTML::styleLocal('webroot/themes/clean-ui/select2.min.css') !!}-->

    @yield('styles')

    @include('layouts.elements.scripts')

    @yield('scripts')

</head>
