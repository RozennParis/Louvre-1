<?php

namespace P4\LouvreBundle\Service;


use P4\LouvreBundle\Entity\Booking;

use Stripe\Charge;
use Stripe\Error\ApiConnection;
use Stripe\Error\Card;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class BookingPay
 * @package P4\LouvreBundle\Service
 */
class BookingPay
{

    private $secretKey;
    /**
     * @var Session
     */
    private $session;

    /**
     * BookingPay constructor.
     * @param $secretKey
     */
    public function __construct($secretKey, SessionInterface $session)

    {
        $this->secretKey = $secretKey;
        $this->session = $session;
    }

    /**
     * @param Booking $booking
     * @param $token
     * @return bool|mixed|null
     */
    public function bookingPay(Booking $booking, $token)
    {

        try {
            Stripe::setApiKey($this->secretKey);
            $charge = Charge::create(array(
                "amount" => $booking->getTotalPrice() * 100,
                "currency" => "eur",
                "source" => $token,
                "description" => "ticketing"
            ));
            return $charge['id'];
           

        } catch (Card $e) {
            $this->session->getFlashBag()->add('error', 'your card is rejected.');
            return false;
        } catch (\Exception $e) {
            $this->session->getFlashBag()->add('error', 'Une erreur est survenue dans le traitement de votre paiement.');
            return false;
        }

    }
}