<!doctype html>
<html>

    @include('layouts.elements.head')

</head>

<body class="@yield('class_body')" style="@yield('style_body')">

    @yield('content')

    @yield('scripts_after')
</body>
</html>