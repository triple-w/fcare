@extends('emails.default')

@section('content')

   <div class="browser_width colelem" id="u1614-4-bw">
    <div class="clearfix" id="u1614-4"><!-- content -->
        <p>{{ $user->getUsername() }}</p>
    </div>
   </div>
   <div class="browser_width colelem" id="u1620-10-bw">
    <div class="clearfix" id="u1620-10"><!-- content -->
     <p id="u1620-2">BIENVENIDO A EASY TAXES</p>
     <p id="u1620-4">GRACIAS POR UNIRTE</p>
     <p id="u1620-6">A LA PLATAFORMA CONTABLE DIGITAL</p>
     <p id="u1620-8">MÁS GRANDE DE MÉXICO</p>
    </div>
   </div>
   <div class="clearfix colelem" id="u1627-14"><!-- content -->
    <div id="u1627-13">
     <p id="u1627-2">Has concluido tu registro y a partir de ahora tendrás derecho a un</p>
     <p id="u1627-4">PERIODO DE PRUEBA GRATIS de 1 mes.</p>
     <p id="u1627-6">Te avisaremos en cuanto tu plan elegido este próximo a vencer donde</p>
     <p id="u1627-8">tendrás opción de cancelar tu membresía, elegir otro plan u optar por el cargo automático mensual de servicios.</p>
     <p id="u1627-10">Para nosotros lo más importante es que te sientas cómodo y</p>
     <p id="u1627-12">satisfecho con nosotros, así que cualquier duda que tengas por favor háznosla saber de inmediato.</p>
    </div>
   </div>

@endsection
