<?php
namespace P4\LouvreBundle\Service;
use P4\LouvreBundle\Entity\Booking;

class EmailSending
{

    private $twig;
    private $mailer;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function SendEmail(Booking $booking)
    {

        $message = (new \Swift_Message('ticket booking'))
            ->setFrom('stephaniehoussinparis@gmail.com')
            ->setTo($booking->getEmail())
            ->setBody(
                $this->twig->render('Louvre/email.html.twig', array(
                    'booking' => $booking)),
                'text/html'
            );
        $this->mailer->send($message);

    }
}