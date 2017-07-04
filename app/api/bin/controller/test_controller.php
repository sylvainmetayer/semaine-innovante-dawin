<?php

namespace controller;

/**
* Controlleur de connection
*/
class test_controller extends \lib\Controller
{
	private $user;
	
	public function __construct($post) {
		parent::__construct($post);

		$this->user = new user();
	}

	public function run($action) {
		return $this->$action();
	}

	public function showrequest() {
		return $_POST;
	}
}