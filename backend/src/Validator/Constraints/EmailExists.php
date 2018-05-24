<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class EmailExists
 * @package App\Validator\Constraints
 * @Annotation
 */
class EmailExists extends Constraint
{
    public $message = "Email already exists";
}