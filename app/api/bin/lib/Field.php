<?php

namespace lib;

/**
* Champ d'un formulaire
*/
class Field
{
	private $name;

	private $validators;

	private $errors;

	public function __construct($name) {
		$this->name = $name;
		$this->validators = [];
		$this->errors = [];
	}

	public function addValidator(Validator $validator) {
		array_push($this->validators, $validator);
		return $this;
	}


	public function isValid($value) {
		foreach ($this->validators as $validator) {
			if(!$validator->isValid($value)){
				array_push($this->errors, $validator->getMsg());
			}
		}

		return empty($this->errors);
	}

	public function getErrors()	{
		return $this->errors;
	}

	public function getName() {
		return $this->name;
	}
}