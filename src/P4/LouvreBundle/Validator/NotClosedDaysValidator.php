<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class NotClosedDaysValidator
 * @package P4\LouvreBundle\Validator
 */
class NotClosedDaysValidator extends ConstraintValidator
{

    const TUESDAY = 2;
    const SUNDAY = 7;

    public function validate($visitDate, Constraint $constraint)
    {
        if($visitDate->format('N') == self::TUESDAY)
        {
            $this->context->buildViolation($constraint->message1)
                ->addViolation();
        }
        if($visitDate->format('N') == self::SUNDAY)
        {
            $this->context->buildViolation($constraint->message2)
                ->addViolation();
        }
    }
}