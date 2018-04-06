<?php

namespace P4\LouvreBundle\Service;


use P4\LouvreBundle\Entity\Booking;

use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;

/**
 * Class BookingPay
 * @package P4\LouvreBundle\Service
 */
class BookingPay
{

  private $secretKey;

    /**
     * BookingPay constructor.
     * @param $secretKey
     */
  public function __construct($secretKey)
  {
      $this->secretKey = $secretKey;
  }

    /**
     * @param Booking $booking
     * @param $token
     * @return bool|mixed|null
     */
  public function bookingPay(Booking $booking,$token)
  {
     Stripe::setApiKey($this->secretKey);


      try {
          $charge = Charge::create(array(
              "amount" => $booking->getTotalPrice() * 100,
              "currency" => "eur",
              "source" => $token,
              "description" => "ticketing"
          ));
          return $charge['id'];

      } catch (Card $e) {

          return false;
      }
  }

}