<div class="contenedor" style="background-image: url(http://factucare.com/sistema/public/webroot/themes/clean-ui/cleanui/build/assets/common/img/temp/login/4.jpg); background-repeat: no-repeat;
background-attachment: fixed;
background-position: center; ">
	<div class="contenido" style="padding: 20px;
		color: #FFFFFF;">
		<div class="image">
			{!! HTML::image('http://factucare.com/sistema/public/webroot/img/logofactu.png', 'Logo', []) !!}
		</div>
		<div class="texto" style="background: #7D7D7D;
		margin-top: 20px;font-size:15px">
			<h3 style="padding: 10px;color: #FFFFFF;"> Estimado(a): {{ $user->getUsername() }} </h3>
			<p style="padding-left: 10px;padding-top:10px">Se ha solicitado una recuperacion de contraseña de su usuario, porfavor de click <a href="{{ action('Users\AccountsController@getRecovery', [ 'id' => $user->getId() ]) }}" style="color: #FFFFFF;font-size: 15px;font-weight: bold;">aqui</a></p>

			<p style="padding-left: 10px;">O puede copiar la siguiente ruta en su navegador</p>

			<p style="padding-left: 10px;padding-bottom:10px;color:#FFFFFF;">{{ action('Users\AccountsController@getRecovery', [ 'id' => $user->getId() ]) }}</p>
		</div>
	</div>
</div>