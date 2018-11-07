<?php

namespace App\Extensions\Doctrine\Validation;

use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

use Flash;

class DoctrineValidation {

	use ValidatesRequests;

	private $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}

	public function getRequest() {
		return $this->request;
	}
	
	public function throwException($options = []) {
		$default = [
			'message' => 'Error de validacion',
			'withInput' => true
		];
		$options += $default;
		Flash::error($options[ 'message' ]);

		throw new HttpResponseException($options['withInput'] ? $this->throwWithInput() : $this->throwWithOutInput());
	}

	private function throwWithInput() {
		return redirect()
			->to($this->getRedirectUrl())
			->withInput($this->request->input());
	}

	private function throwWithOutInput() {
		return redirect()
			->to($this->getRedirectUrl());
	}

}

?>