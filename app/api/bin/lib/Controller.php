<?php

namespace lib;

/**
* Tous les controlleurs
*/
abstract class Controller
{
	private $response;

	private $post;

	public function __construct($post) {
		$this->post = $post;
		$response = [];
	}

	abstract public function run($action);

	public function get404() {
		return ['error' => 404];
	}

	public function get($index) {
		return empty($this->post[$index]) ? null : $this->post[$index];
	}

	public function set($index, $value) {
		$this->response[$index] = $value;
	}

	public function getResponse() {
		return $this->response;
	}
}
