<?php
/**
 * Created by PhpStorm.
 * User: oriamn
 * Date: 06/07/17
 * Time: 11:33
 */

namespace validator;


use lib\Validator;

class EmailValidator extends Validator
{
    public function isValid($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}