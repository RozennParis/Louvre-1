<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ThousandValidator
 * @package P4\LouvreBundle\Validator
 */
class ThousandValidator extends ConstraintValidator
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
