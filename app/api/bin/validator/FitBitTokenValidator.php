<?php
/**
 * Created by PhpStorm.
 * User: oriamn
 * Date: 06/07/17
 * Time: 11:45
 */

namespace validator;


use lib\Validator;

class FitBitTokenValidator extends Validator
{

    public function isValid($value)
    {
        return is_string($value);
    }
}