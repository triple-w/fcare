<?php
/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/
$env = $app->detectEnvironment(function(){

	$httpHost = ( isset($_SERVER['HTTP_HOST']) ) ? $_SERVER['HTTP_HOST'] : 'localhost';
	switch ($httpHost) {
		case strpos($httpHost, 'localhost'):
			$setEnv = 'local';
			break;
		case 'www.factucare.com':
		case 'factucare.com':
			$setEnv = 'test';
			break;
		default:
			$setEnv = 'production';
	}

	// switch ($httpHost) {
	// 	case "local":
	// 		$setEnv = 'local';
	// 	break;
	// 	default:
	// 		$setEnv = 'production';
	// }

	// dump($setEnv, $httpHost);die;

	$setEnv = 'production';
	putenv("APP_ENV={$setEnv}");
	if (getenv('APP_ENV') && file_exists(__DIR__.'/../.' .getenv('APP_ENV') .'.env')) {
		$dotenv = new Dotenv\Dotenv(__DIR__ . '/../', '.' . getenv('APP_ENV') . '.env');
		$dotenv->overload();
	} else {
		throw Expection('No existe archivo de configuracion ' .__DIR__ . '/../', '.' . getenv('APP_ENV') . '.env' );
	}

});
