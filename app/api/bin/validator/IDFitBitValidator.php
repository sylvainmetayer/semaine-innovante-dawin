<?php

namespace validator;

use lib\Validator;

/**
* Validateur d'entier
*/
class IDFitBitValidator extends Validator
{
	public function __construct($msg) {
		parent::__construct($msg);
	}

	public function isValid($value) {
		return is_string($value);
	}
}