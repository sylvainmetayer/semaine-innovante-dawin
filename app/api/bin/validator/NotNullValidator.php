<?php

namespace validator;

use lib\Validator;

/**
* Validateur de présence
*/
class NotNullValidator extends Validator
{
	public function __construct($msg) {
		parent::__construct($msg);
	}

	public function isValid($value) {
		return $value !== null;
	}
}