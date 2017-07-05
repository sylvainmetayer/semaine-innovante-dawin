<?php

namespace lib;

/**
* Tous les controlleurs
*/
abstract class Controller
{
	private $post;
	private $db;

	public function __construct($post, $db) {
		$this->post = $post;
		$this->db = $db;
	}

	abstract public function run($action);

	public function get404() {
		return ['error' => 404];
	}

	public function get($index) {
		return empty($this->post[$index]) ? null : $this->post[$index];
	}


    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }
}
