<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class NotPossibleBookingValidator
 * @package P4\LouvreBundle\Validator
 */
class NotPossibleBookingValidator extends ConstraintValidator
{

   public function validate($visitDate, Constraint $constraint)
   {
       if(in_array($visitDate->format('d/m'), $constraint->dayClosed, true))
       {
           $this->context->buildViolation($constraint->message)
               ->addViolation();
       }
   }
}