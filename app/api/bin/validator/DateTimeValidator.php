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
		
		$DateTime = \DateTime::createFromFormat($format, $date);
     
        return ( $DateTime && $date == $DateTime->format($format) );
	}
}