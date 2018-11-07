<?php

namespace App\Extensions\Bootstrapper;

use Auth;

class Navigation extends \Bootstrapper\Navigation {

	private function isDropdownLink($link) {
		foreach ($link as $key => $value) {
			if (is_array($value) && $key !== 'rol') {
				return $key;
			}
		}

		return -1;
	}

	public function links(array $links) {
    	$user = Auth::user();

    	foreach ($links as $key => $link) {
    		if (array_key_exists('rol', $link)) {
    			if (is_array($link['rol'])) {
	    			if (!in_array($user->getRol(), $link['rol'])) {
	    				if (isset($links[$key])) {
	    					unset($links[$key]);
	    				}
	    			}
    			} else {
    				if ($user->getRol() !== $link['rol']) {
    					if (isset($links[$key])) {
	    					unset($links[$key]);
	    				}
	    			}
    			}
    		}


    		if (($pos = $this->isDropdownLink($link)) > -1) {
    			foreach ($link[$pos] as $subKey => $subLink) {
    				if (array_key_exists('rol', $subLink)) {
    					if (is_array($subLink['rol'])) {
			    			if (!in_array($user->getRol(), $subLink['rol'])) {
			    				if (isset($links[$key][$pos][$subKey])) {
			    					unset($links[$key][$pos][$subKey]);
			    				}
			    			}    						
    					} else {
    						if ($user->getRol() !== $subLink['rol']) {
							if (isset($links[$key][$pos][$subKey])) {
				    				unset($links[$key][$pos][$subKey]);
							}
			    			}    						
    					}
		    		}
    			}
    		}
    	}
	    	
        return parent::links($links);
    }

}

?>