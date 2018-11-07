<!doctype html>
<html>

    <title>@yield('title')</title>
    @include('layouts.elements.head')

<body>

    @include('layouts.elements.header' ,[ 'include' => 'layouts.elements.navigation_admin'])

    <main class="main-content">
        <div class="container">
            @yield('breadcrumbs')
            @include('flash::message')
            @yield('content')
        </div>
    </main>

    @include('layouts.elements.footer')

</body>
</html>
