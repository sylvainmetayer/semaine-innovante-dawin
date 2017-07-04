<?php

namespace controller;

use \entity\user;

/**
* Controlleur de connection
*/
class auth_controller extends \lib\Controller
{
	private $user;
	
	public function __construct($post) {
		parent::__construct($post);

		$this->user = new user();
	}

	public function run($action) {
		return $this->$action();
	}

	public function login() {
		return ['login' => 'test'];
	}
}