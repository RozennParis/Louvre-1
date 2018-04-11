<?php
namespace P4\LouvreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Entity\Ticket;

/**
 * Class ThousandValidator
 * @package P4\LouvreBundle\Validator
 */
class ThousandValidator extends ConstraintValidator
{

     private $em;


     public function __construct(EntityManagerInterface $em)
     {
         $this->em = $em;
     }

    /**
     * @param mixed $booking
     * @param Constraint $constraint
     */
    public function validate($booking, Constraint $constraint)
    {
        $ticketsSold = $this->em->getRepository(Ticket::class);
        $nbDayTickets = $ticketsSold->getNbTicketsPerDay();
        if($nbDayTickets + $booking->getNbTickets() > Booking::MAX_TICKETS_PER_DAY)
        {
            $this->context->buildViolation($constraint->message)
                ->atPath('nbTickets')
                ->addViolation();
        }

     }


}
