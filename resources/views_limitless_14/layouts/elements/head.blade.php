<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="csrf-token" value="{{ csrf_token() }}" />
    <meta id="url-public" value="{{ asset('') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/webroot/img/favicon/apple-icon-57x57.png') }} ">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('/webroot/img/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/webroot/img/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/webroot/img/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/webroot/img/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/webroot/img/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/webroot/img/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/webroot/img/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/webroot/img/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('/webroot/img/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/webroot/img/favicon/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/webroot/img/favicon/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/webroot/img/favicon/favicon.png') }}">
    <link rel="manifest" href="{{ asset('/webroot/img/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('/webroot/img/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- HTML5 shim and Respond.js for < IE9 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    {!! HTML::style('assets/css/icons/icomoon/styles.css') !!}
    {!! HTML::style('assets/css/icons/fontawesome/styles.min.css') !!}
    {!! HTML::style('assets/css/bootstrap.css') !!}
    {!! HTML::style('assets/css/core.css') !!}
    {!! HTML::style('assets/css/components.css') !!}
    {!! HTML::style('assets/css/colors.css') !!}
    <!-- /global stylesheets -->
    {!! HTML::styleLocal('webroot/css/main.css') !!}

    @yield('styles')

    @include('layouts.elements.scripts')

    @yield('scripts')

</head>
