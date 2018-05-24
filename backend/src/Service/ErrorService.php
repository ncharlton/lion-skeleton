<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 16.04.2018
 * Time: 10:42
 */

namespace App\Service;

use JMS\Serializer\Serializer;
use JMS\SerializerBundle\JMSSerializerBundle;
use Symfony\Component\Validator\ConstraintViolation;

class ErrorService
{
    public function __construct()
    {

    }

    public function validationErrors($errors) {
        $errorMessages = [];
        $counter = 0;
        foreach($errors as $key => $value) {
            $counter++;
            $errorMessages[$counter] = $value;
        }
        return $errorMessages;
    }
}