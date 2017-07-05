<?php

namespace form;

use lib\Form;

use lib\Field;

use validator\IDFitBitValidator;

use validator\NotNullValidator;


/**
* Formulaire de selection
*/
class SelectResultForm extends Form
{
	public function __construct() {
		parent::__construct();
	}


	public function build() {
		$this->addField( new Field('id_user_fitbit') )
			 ->addValidator(new NotNullValidator("Id fit not null"))
			 ->addValidator(new IDFitBitValidator("Id fitbit invalid"));
	}
}