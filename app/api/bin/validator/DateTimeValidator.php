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
		$this->format = $format;
	}
	public function isValid($value) {

		$dateTimeObj = \DateTime::createFromFormat($this->format, $value);

        $dateErrors = \DateTime::getLastErrors();
        $this->msg .= chr(10). implode($dateErrors['warnings'], chr(10));
        $this->msg .= chr(10). implode($dateErrors['errors'], chr(10));
     
        return empty($dateErrors['warning_count']) && empty($dateErrors['error_count']) &&
               $dateTimeObj && $value == $dateTimeObj->format($this->format);
	}
}