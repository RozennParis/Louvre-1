<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class NotClosedTuesdayValidator
 * @package P4\LouvreBundle\Validator
 */
class NotClosedTuesdayValidator extends ConstraintValidator
{

    const TUESDAY = 2;

    public function validate($visitDate, Constraint $constraint)
    {
        if($visitDate->format('N') == self::TUESDAY)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}