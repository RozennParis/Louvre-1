<?php
namespace P4\LouvreBundle\Service;

use P4\LouvreBundle\Entity\Booking;

/**
 * Class PriceCalculation
 * @package P4\LouvreBundle\Service
 */
class PriceCalculation
{
    const AGE_BB = 4;
    const AGE_CHILD = 12;
    const AGE_SENIOR = 60;

    const PRICE_BB = 0;
    const PRICE_CHILD = 8;
    const PRICE_SENIOR = 12;
    const PRICE_NORMAL = 16;
    const PRICE_REDUCED = 10;

    const FULL_DAY = 1;
    const HALF_DAY = 0.5;

    private $coefficient;

    /**
     * @param Booking $booking
     * @return Booking
     */
    public function priceCalculation(Booking $booking)
    {
        switch ($booking->getTicketType())
        {
            case Booking::BOOKING_FULL_DAY:
                $this->coefficient = self::FULL_DAY;
                break;
            case Booking::BOOKING_HALF_DAY:
                $this->coefficient = self::HALF_DAY;
                break;
        }

        $tickets = $booking->getTickets();
        $visitDate = $booking->getVisitDate();
        $totalPrice = 0;

        foreach ($tickets as $ticket) {
            $price = 0;
            $age = $ticket->getBirthDate()->diff($visitDate)->format('%y');
        

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

            $price = $price * $this->coefficient;
            $ticket->setPrice($price);
            $totalPrice += $price;
        }
        $booking->setTotalPrice($totalPrice);
        return $booking;
    }


}