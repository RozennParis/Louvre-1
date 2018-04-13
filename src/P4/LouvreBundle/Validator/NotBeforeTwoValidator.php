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
     * @param mixed $booking
     * @param Constraint $constraint
     */
    public function validate($booking, Constraint $constraint)
    {
        $currentDateTime = new \DateTime();
        $date = $booking->getVisitDate()->format('d-m-y');
        $currentDate = date('d-m-y');
        $hour = $currentDateTime->format('H:i');
        if($hour > 10 && $currentDate == $date)
        {
            $ticketType = $booking->getTicketType();
            if($ticketType == "day")
            {
                $this->context->buildViolation($constraint->message)
                    ->atPath('ticketType')
                    ->addViolation();
            }
        }
    }
}