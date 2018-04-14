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
        $now = new \DateTime(); // date d'aujourd'hui
        $addingDays = 20; // ajout de 20 jours
        $interval = new \DateInterval('P'.$addingDays.'D'); // création de l'intervalle -> 20 jours
        $this->visitDate = $now->add($interval);// Ajout des 20 jours à aujourd'hui  ->  visitDate
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
        $interval = new \DateInterval('P'.$age.'Y');// creation de l'intervalle âge
        // ici $interval contient les différentes valeurs âges

        // dans un premier temps je déclare que $bithDate = $visitDate
        $birthDate =  clone $this->visitDate;
        // si je lance un test maintenant j'ai 12 failures -> seules les 4 correspondant à une naissance du jour passent
        // donc les 4 à age = 0

        // Dans un deuxième temps je vais calculer les dates de naissance
        // J'ote $interval (qui contient mes âges ) à $birthdate qui contient la date de la visite
        $birthDate = $birthDate->sub($interval);
        // $birthDate contient maintenant les dates de naissances au format yyyy-mm-dd

        // je crée ma commande
        $booking = new Booking();
        $booking->setVisitDate($this->visitDate); // contient la date du jour + 20 jours au format yyyy-mm-dd
        $booking->setNbTickets(1);
        $booking->setTicketType($ticketType);

        $ticket = new Ticket();
        $ticket->setBirthDate($birthDate); // contient la date de naissance au format yyyy-mm-dd
        $ticket->setReducedPrice($reducedPrice);

        $ticket->setBooking($booking);
        $booking->addTicket($ticket);

        $priceCalculation = new PriceCalculation();
        $booking = $priceCalculation->priceCalculation($booking);
        $tickets = $booking->getTickets();
        foreach ($tickets as $ticket)
        {
            $price = $ticket->getPrice();
        }
        $this->assertEquals($expected, $price);

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