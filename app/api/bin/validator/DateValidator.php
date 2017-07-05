<?php

namespace validator;

use lib\Validator;

/**
* Validateur de date
*/
class DateTimeValidator extends Validator
{
	private $format;

	public function __construct($msg, $format) {

		parent::__construct($msg);

		$this->format = format;
	}

	public function isValid($value) {
		$date = DateTime::createFromFormat($this->format, $value);
		$errors = DateTime::getLastErrors();

		return $errors['warning_count'] + $errors['error_count'] == 0;
	}
}