<?php
namespace P4\LouvreBundle\Manager;

use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use P4\LouvreBundle\Service\Mailer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BookingManager
 * @package P4\LouvreBundle\Manager
 */
class BookingManager
{
    const SESSION_CURRENT_BOOKING_ID_KEY = "current_booking_id";

    private $session;
    private $em;
    /**
     * BookingManager constructor.
     * @param SessionInterface $session
     * @param EntityManagerInterface $em
     * @param Mailer $mailer
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $em, Mailer $mailer)
    {
        $this->session = $session;
        $this->em = $em;
        $this->mailer = $mailer;
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
     */
    public function getBooking()
    {
        $booking = $this->getSession();
        if(!$booking)
        {
            throw new NotFoundHttpException('Error');
        }
        return $booking;
    }
    /**
     * @param Booking $booking
     */
    public function setBooking(Booking $booking)
    {
        $this->setSession($booking);
    }
    /**
     * @return mixed
     */
    public function getSession()
    {

        return $this->session->get('booking');

    }
    /**
     * @param Booking $booking
     */
    public function setSession(Booking $booking)
    {
        $this->session->set('booking',$booking);
    }
    /**
     * @param Booking $booking
     */
    public function startBooking(Booking $booking)
    {

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
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function finishBooking(Booking $booking)
    {
        $this->em->persist($booking);
        $this->em->flush();
        $this->mailer->sendEmail($booking);
    }

    public function close()
    {
        $booking = $this->getSession();
        $this->session->clear();
        $this->session->set(self::SESSION_CURRENT_BOOKING_ID_KEY,$booking->getId());
    }

    /**
     * @return null|object|Booking
     */
    public function recBooking()
    {
        $booking = $this->em->getRepository('P4LouvreBundle:Booking')->find($this->session->get(self::SESSION_CURRENT_BOOKING_ID_KEY));
        if(!$booking)
        {
            throw new NotFoundHttpException('Error');
        }
        return $booking;
    }
}
