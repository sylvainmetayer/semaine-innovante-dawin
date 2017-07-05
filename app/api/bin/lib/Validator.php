<?php

namespace lib;

/**
* Validateur de données
*/
abstract class Validator
{
	private $msg;
	
	public function __construct($msg) {
		$this->msg = $msg;
	}

	public function getMsg() {
		return $this->msg;
	}

	abstract public function isValid($value);
}