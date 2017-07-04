<?php

namespace lib;

/**
* Tous les controlleurs
*/
abstract class Controller
{
	private $response;

	private $post;
	private $db;

	public function __construct($post, $db) {
		$this->post = $post;
		$this->db = $db;
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

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }
}
