<?php

namespace App\Extensions\Flash;

class FlashNotifier extends \Laracasts\Flash\FlashNotifier {

	private $session;

	public function __construct(\Laracasts\Flash\SessionStore $session) {
		parent::__construct($session);
		$this->session = $session;
	}

	public function createMessage($type, $options = array()) {

		$this->session->flash('flash_notification.title_msg', 
			isset($options['title_msg']) ? $options['title_msg'] : '');

		if (isset($options['icon'])) {
			$this->session->flash('flash_notification.icon_name', 
				isset($options['icon']['name']) ? $options['icon']['name'] : $options['icon']);

			$this->session->flash('flash_notification.icon_animated', 
				isset($options['icon']['animated']) ? $options['icon']['animated'] : '');

			$this->session->flash('flash_notification.icon_rotate', 
				isset($options['icon']['rotate']) ? $options['icon']['rotate'] : '');
		}

		parent::message($options['message'], $type);
	}


}

?>