
@section('title', 'Transferir Timbres')

@section('content')

    {!! BootForm::open(); !!}
    	@if(Auth::user()->getId() == 1)
   			@set('usuarios', [])
    		@foreach (\App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO']) as $usuario)
	    		@set("usuarios[$usuario->getId()]", $usuario->getUsername())
    		@endforeach
    	@else
    		@set('usuarios', [])
    		@foreach (\App\Models\Users::findBy([ 'rol' => 'ROLE_USUARIO' , 'admin' => Auth::user()->getId() ]) as $usuario)
    			@set("usuarios[$usuario->getId()]", $usuario->getUsername())
    		@endforeach
    	@endif
    	
    	{!! BootForm::select('userTransferencia', 'Usuario', $usuarios, [], []) !!}
        {!! BootForm::text('numeroTimbres', 'Numero de timbres', null, []) !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection