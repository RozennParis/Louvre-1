<?php
namespace P4\LouvreBundle\Service;

use P4\LouvreBundle\Entity\Booking;

class PriceCalculation
{

    //age
    const AGE_BB = 4;
    const AGE_CHILD = 12;
    const AGE_SENIOR = 60;

    //price
    const PRICE_BB = 0;
    const PRICE_CHILD = 8;
    const PRICE_SENIOR = 12;
    const PRICE_NORMAL = 16;
    const PRICE_REDUCED = 10;


    public function PriceCalculation(Booking $booking) {

        $tickets = $booking->getTickets();
        $totalPrice = 0;

        foreach ($tickets as $ticket) {
            $age = $ticket->getBirthDate()->diff($booking->getVisitDate())->format('%y');

            if ($age < self::AGE_BB) {
                $price = self::PRICE_BB;
            } elseif ($age < self::AGE_CHILD) {
                $price = self::PRICE_CHILD;
            } elseif ($age < self::AGE_SENIOR) {
                $price = self::PRICE_NORMAL;
            } else {
                $price = self::PRICE_SENIOR;
            }
            if ($ticket->getReducedPrice() && $price > self::PRICE_REDUCED) {
                $price = self::PRICE_REDUCED;
            }

            $ticket->setPrice($price);

            $totalPrice += $price;
        }

        $booking->setTotalPrice($totalPrice);

        return $booking;

    }


}