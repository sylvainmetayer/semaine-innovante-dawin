<?php

namespace form;

use lib\Field;
use validator\DateTimeValidator;
use validator\PositiveIntegerValidator;
use validator\NotNullValidator;

/**
* Formulaire
*/
class InsertResultForm extends SelectResultForm
{
	public function __construct() {
		parent::__construct();

		return $this;
	}

    public function build() {
	    parent::build();

        $this->addField( new Field('date') )
            ->addValidator(new NotNullValidator("Date not null"))
            ->addValidator(new DateTimeValidator("Format de la date invalide", "d-m-Y H:i:s"));

        $this->addField( new Field('first_hr') )
            ->addValidator(new NotNullValidator("Id fit not null"))
            ->addValidator(new PositiveIntegerValidator("Invalid integer"));

        $this->addField( new Field('second_hr') )
            ->addValidator(new NotNullValidator("Id fit not null"))
            ->addValidator(new PositiveIntegerValidator("Invalid integer"));

        $this->addField( new Field('third_hr') )
            ->addValidator(new NotNullValidator("Id fit not null"))
            ->addValidator(new PositiveIntegerValidator("Invalid integer"));
    }
}