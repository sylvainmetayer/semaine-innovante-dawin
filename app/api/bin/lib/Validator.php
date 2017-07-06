<?php

namespace lib;

/**
* Validateur de données
*/
abstract class Validator
{
	protected $msg;
	
	public function __construct($msg) {
		$this->msg = $msg;
	}

	public function getMsg() {
		return $this->msg;
	}

	abstract public function isValid($value);
}