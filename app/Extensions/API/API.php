<?php

namespace App\Extensions\API;

use Request;
use Route;

class API {

	private $username = 'admin';

	private $token = '177084dee357d5e40ac1b6cd1d45e3f9';

	public function setUsername($username) {
		$this->username = $username;

		return $this;
	}

	public function setToken($token) {
		$this->token = $token;

		return $this;
	}	

	public function send($url, $method, $data) {
		$requestData = array_merge($this->getCredentials(), $data);
		$request = Request::create($url, $method, $requestData);
        $response = Route::dispatch($request);

        return $response;
	}

	private function getCredentials() {
		return [ 'username' => $this->username, 'token' => $this->token ];
	}

}

?>