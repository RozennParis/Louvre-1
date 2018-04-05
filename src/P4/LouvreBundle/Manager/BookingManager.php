<?php
namespace P4\LouvreBundle\Manager;

use Exception;
use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use P4\LouvreBundle\Service\EmailSending;
class BookingManager
{
    private $session;
    private $em;

    /**
     * BookingManager constructor.
     * @param SessionInterface $session
     * @param EntityManagerInterface $em
     * @param EmailSending $emailSending
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $em, EmailSending $emailSending)
    {
        $this->session = $session;
        $this->em = $em;
        $this->emailSending = $emailSending;
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
        $this->em->persist($booking);
        $this->em->flush();

        $this->emailSending->sendEmail($booking);

    }

    public function close()
    {
        $this->session->clear();
    }

    /**
     * @param $id
     * @return null|object|Booking
     * @throws Exception
     */
    public function recBooking($id)
    {
        $booking = $this->em->getRepository('P4LouvreBundle:Booking')->find($id);
        if(!$booking)
        {
            throw new Exception('erreur');
        }

        return $booking;
    }

}