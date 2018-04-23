<?php
namespace Tests\P4\LouvreBundle\Service;

use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Entity\Ticket;
use P4\LouvreBundle\Service\PriceCalculation;
use PHPUnit\Framework\TestCase;

class PriceCalculationTest extends TestCase
{
    protected $visitDate;

    public function setUp()
    {
        // CREATION DE MA DATE DE VISITE
        $now = new \DateTime();
        $addingDays = 20;
        $interval = new \DateInterval('P'.$addingDays.'D');
        $this->visitDate = $now->add($interval);
    }

    /**
     * @dataProvider dataProvider
     * @param $age
     * @param $ticketType
     * @param $reducedPrice
     * @param $expected
     * @throws \Exception
     */
    public function testPrice($age, $ticketType, $reducedPrice, $expected)
    {
        // CREATION DE LA DATE DE NAISSANCE
        $interval = new \DateInterval('P'.$age.'Y');
        $birthDate =  clone $this->visitDate;
        $birthDate = $birthDate->sub($interval);

        $booking = new Booking();
        $booking->setVisitDate($this->visitDate);
        $booking->setNbTickets(1);
        $booking->setTicketType($ticketType);

        $ticket = new Ticket();
        $ticket->setBirthDate($birthDate);
        $ticket->setReducedPrice($reducedPrice);

        $ticket->setBooking($booking);
        $booking->addTicket($ticket);

        $priceCalculation = new PriceCalculation();
        $priceCalculation->priceCalculation($booking);
        $this->assertEquals($expected, $booking->getTotalPrice());

    }
    public function dataProvider()
    {
        return[
            [2, Booking::BOOKING_FULL_DAY, Ticket::REDUCED_PRICE, 0],
            [2, Booking::BOOKING_FULL_DAY, Ticket::NO_REDUCED_PRICE, 0],
            [2, Booking::BOOKING_HALF_DAY, Ticket::REDUCED_PRICE, 0],
            [2, Booking::BOOKING_HALF_DAY, Ticket::NO_REDUCED_PRICE, 0],
            [11, Booking::BOOKING_FULL_DAY, Ticket::REDUCED_PRICE, 8],
            [11, Booking::BOOKING_FULL_DAY, Ticket::NO_REDUCED_PRICE,8],
            [11, Booking::BOOKING_HALF_DAY, Ticket::REDUCED_PRICE, 4],
            [11, Booking::BOOKING_HALF_DAY, Ticket::NO_REDUCED_PRICE,4],
            [41, Booking::BOOKING_FULL_DAY, Ticket::REDUCED_PRICE, 10],
            [41, Booking::BOOKING_FULL_DAY, Ticket::NO_REDUCED_PRICE, 16],
            [41, Booking::BOOKING_HALF_DAY, Ticket::REDUCED_PRICE,5],
            [41, Booking::BOOKING_HALF_DAY, Ticket::NO_REDUCED_PRICE, 8],
            [73, Booking::BOOKING_FULL_DAY, Ticket::REDUCED_PRICE, 10],
            [73, Booking::BOOKING_FULL_DAY, Ticket::NO_REDUCED_PRICE, 12],
            [73, Booking::BOOKING_HALF_DAY, Ticket::REDUCED_PRICE, 5],
            [73, Booking::BOOKING_HALF_DAY, Ticket::NO_REDUCED_PRICE, 6],
        ];
    }
}