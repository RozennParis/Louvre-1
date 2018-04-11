<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ClosedSundayValidator
 * @package P4\LouvreBundle\Validator
 */
class ClosedSundayValidator extends ConstraintValidator
{

    const SUNDAY = 7;

    /**
     * @param mixed $visitDate
     * @param Constraint $constraint
     */
    public function validate($visitDate, Constraint $constraint)
    {

        if($visitDate->format('N') == self::SUNDAY)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}