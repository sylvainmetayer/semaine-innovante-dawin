<?php

namespace controller;

use \entity\user;

/**
* Controlleur de connection
*/
class auth_controller extends \lib\Controller
{
	private $user;
	
	function __construct($post) {
		$this->user = new user();
	}

	function run($action) {
		return $this->$action();
	}

	public function login() {
		return ['login' => 'test'];
	}
}