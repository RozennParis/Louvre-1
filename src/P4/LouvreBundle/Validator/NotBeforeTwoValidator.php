<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class NotBeforeTwoValidator
 * @package P4\LouvreBundle\Validator
 */
class NotBeforeTwoValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
   public function validate($value, Constraint $constraint)
   {
       // TODO: Implement validate() method.
   }
}