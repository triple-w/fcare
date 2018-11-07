<?php

namespace App\Extensions\API\Facades;

use Illuminate\Support\Facades\Facade; 

class APIFacade extends Facade {
	
	protected static function getFacadeAccessor() { 
		return 'API';
	}

}

?>