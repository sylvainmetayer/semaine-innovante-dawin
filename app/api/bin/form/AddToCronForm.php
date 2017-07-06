<?php
/**
 * Created by PhpStorm.
 * User: oriamn
 * Date: 06/07/17
 * Time: 11:36
 */

namespace form;


use lib\Field;
use lib\Form;
use validator\DateTimeValidator;
use validator\EmailValidator;
use validator\FitBitTokenValidator;
use validator\IDFitBitValidator;
use validator\NotNullValidator;

class AddToCronForm extends Form
{

    public function build()
    {
        $this->addField( new Field('token') )
            ->addValidator(new NotNullValidator("Token not null"))
            ->addValidator(new FitBitTokenValidator("Token fitbit invalide"));

        $this->addField( new Field('userID') )
            ->addValidator(new NotNullValidator("UserId not null"))
            ->addValidator(new IDFitBitValidator("User Id invalide"));

        $this->addField( new Field('email') )
               ->addValidator(new NotNullValidator('Email not null'))
               ->addValidator(new EmailValidator('Format email incorrect'));

        $this->addField( new Field('startTime') )
            ->addValidator(new NotNullValidator("Date not null"))
            ->addValidator(new DateTimeValidator("Format de date invalide", "H:i:s"));

        $this->addField( new Field('endTime') )
            ->addValidator(new NotNullValidator("Date not null"))
            ->addValidator(new DateTimeValidator("Format de date invalide", "H:i:s"));


    }
}