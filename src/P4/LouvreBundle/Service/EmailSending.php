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

    public function sendEmail(Booking $booking)
    {

        $message = \Swift_Message::newInstance()
            ->setSubject('ticketing')
            ->setFrom('stephaniehoussinparis@gmail.com')
            ->setTo($booking->getEmail())
            ->setCharset('utf-8')
            ->setContentType('text/html')
            ->setBody(
                $this->twig->render('Email/email.html.twig', array(
                    'booking' => $booking)));
        $this->mailer->send($message);

    }
}