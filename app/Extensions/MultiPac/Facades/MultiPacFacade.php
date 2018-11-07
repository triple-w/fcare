<?php

namespace App\Extensions\MultiPac\Facades;

use Illuminate\Support\Facades\Facade; 

class MultiPacFacade extends Facade {
	
	protected static function getFacadeAccessor() { 
		return 'MultiPac';
	}

}

?>