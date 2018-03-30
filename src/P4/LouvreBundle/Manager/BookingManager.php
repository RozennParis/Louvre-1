<?php
namespace P4\LouvreBundle\Manager;

use Exception;
use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
class BookingManager
{
    private $session;
    private $em;

    /**
     * BookingManager constructor.
     * @param SessionInterface $session
     * @param EntityManagerInterface $em
     * @param \Swift_Mailer $mailer
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    /**
     * @return Booking
     */
    public function initBooking()
    {
        $booking = $this->getSession();
        if(!$booking)
        {
            $booking = new booking();
        }
        return $booking;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getBooking()
    {
        $booking = $this->getSession();
        if(!$booking)
        {
            throw new Exception();
        }
        return $booking;
    }
    public function setBooking(Booking $booking)
    {
        $this->setSession($booking);
    }

    public function getSession()
    {
        
     return $this->session->get('booking');
          
    }

    public function setSession(Booking $booking)
    {
        $this->session->set('booking',$booking);
    }

    public function startBooking(Booking $booking)
    {
        // faire if > et if <
        
        while (count($booking->getTickets()) < $booking->getNbTickets()) {
            $ticket = new Ticket();
            $booking->addTicket($ticket);
        }
        while (count($booking->getTickets()) > $booking->getNbTickets()) {
            $ticket = $booking->getTickets()->last();
            $booking->removeTicket($ticket);
        }
        $this->setSession($booking);

    }

    /**
     * @param Booking $booking
     */
    public function finishBooking(Booking $booking)
    {
        $this->setSession($booking);
        $this->em->persist($booking);
        $this->em->flush();
        //envoi de l'email
    }
}