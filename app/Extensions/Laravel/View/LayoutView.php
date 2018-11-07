<?php

namespace App\Extensions\Laravel\View;

use Session;

trait LayoutView {

	private $layout = 'layouts.default';
	
    public function render($view, $data = []) {
        return view($this->layout)->nest('child', $view, $data);
    }

    public function JSONResponse($data = [], $success = true) {
        if ($this->request->ajax()) {
            if (Session::has('notifier.notice')) {
                $data['pnotify'] = Session::get('notifier.notice');
            }
        }

        return [ 'success' => $success, 'data' => $data ];
    }

    public function renderOnlyView($view, $data = []) {
		return view($view, $data);    	
    }

    protected function setLayout($name)
    {
        $this->layout = "layouts.{$name}";
    }
	
}

?>