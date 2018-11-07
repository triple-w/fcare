<!doctype html>
<html>

    @include('layouts.elements.head')

</head>

<body class="@yield('class_body')" style="@yield('style_body')">

    @yield('content')

    @yield('scripts_after')

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5a3831bbf4461b0b4ef89764/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->

    <!-- <script> -->
    <!--     window.intergramId = "301620493"; -->
    <!--     window.intergramCustomizations = { -->
    <!--         titleClosed: 'En que podemos ayudarte?', -->
    <!--         titleOpen: 'Comentanos tu duda', -->
    <!--         introMessage: 'Comentanos tu duda', -->
    <!--         autoResponse: 'Espera, en un momento te atenderemos', -->
    <!--         autoNoResponse: 'Por el momento no estamos disponibles, pero en cuanto lo estemos te ayudaremos con todo gusto.', -->
    <!--     }; -->
    <!-- </script> -->
    <!-- <script id="intergram" type="text/javascript" src="https://www.intergram.xyz/js/widget.js"></script> -->

</body>
</html>