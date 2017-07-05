<?php

namespace lib;

/**
* Formulaire
*/
abstract class Form
{
	private $fields;

	private $errors;

	private $values;

	public function __construct() {
		$this->fields = [];
		$this->errors = [];
	}

	public function addField(Field $field) {
		$this->fields[$field->getName()] = $field;
		return $field;
	}

	abstract public function build();


	public function isValid(Controller $controller) {

		foreach ($this->fields as $field) {
			$value = $controller->get($field->getName());

			$this->values[$field->getName()] = $value;

			if(!$field->isValid($value)) {
				array_push($this->errors, [$field->getName()." errors : " => $field->getErrors()]);
			}
		}

		return empty($this->errors);
	}

	public function getValues()	{
		return $this->values;
	}


	public function getErrors()	{
		return $this->errors;
	}
}