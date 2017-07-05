<?php

namespace validator;

use lib\Validator;

/**
* Validateur d'entier
*/
class PositiveIntegerValidator extends Validator
{
	public function __construct($msg) {
		parent::__construct($msg);
	}

	public function isValid($value) {
		return filter_var($value, FILTER_VALIDATE_INT) && intval($value) > 0;
	}
}