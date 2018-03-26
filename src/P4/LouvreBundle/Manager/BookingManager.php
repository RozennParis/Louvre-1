<?php
namespace P4\LouvreBundle\Manager;

use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Entity\Ticket;

class BookingManager
{
    /**
     * @param Booking $booking
     */
    public function startBooking(Booking $booking)
    {
        while(count($booking->getTickets())< $booking->getNbTickets())
        {
            $ticket = new Ticket();
            $booking->addTicket($ticket);
        }
        while(count($booking->getTickets()) > $booking->getNbTickets())
        {
            $ticket = $booking->getTickets()->last();
            $booking->removeTicket($ticket);
        }

    }

}