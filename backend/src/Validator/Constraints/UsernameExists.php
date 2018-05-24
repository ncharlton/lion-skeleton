<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 16.04.2018
 * Time: 11:29
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UsernameExists extends Constraint {
    public $message = 'This username already exists';
}