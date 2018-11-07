@extends('emails.default')

@section('content')
   <div class="browser_width colelem" id="u1614-4-bw">
    <div class="clearfix" id="u1614-4"><!-- content -->
        <p>{{ $user->getUsername() }}</p>
    </div>
   </div>
    <p>Se ha solicitado una recuperacion de contraseña de su usuario.</p>
    <a href="{{ action('Users\AccountsController@getRecovery', [ 'id' => $user->getId() ]) }}">Recuperar Contraseña</a><!--[endif]-->

@endsection
