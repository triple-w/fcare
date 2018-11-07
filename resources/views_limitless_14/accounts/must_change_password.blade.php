
@section('title', 'Cambiar Password')

@section('content')

	{!! Alert::info('Antes debes de cambiar tu contraseña') !!}

	<div class="row">
        <div class="col-md-5 col-md-offset-3 well">
		    {!! BootForm::open(); !!}
		        {!! BootForm::password('password', 'Password Nuevo', ['required' => 'required']); !!}
		        {!! BootForm::password('password_confirmation', 'Password Confirm', ['required' => 'required']); !!}
		        {!! BootForm::submit('Agregar'); !!}
		    {!! BootForm::close(); !!}
	    </div>
    </div>

@endsection