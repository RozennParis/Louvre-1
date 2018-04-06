<?php
namespace P4\LouvreBundle\Service;
use P4\LouvreBundle\Entity\Booking;

/**
 * Class EmailSending
 * @package P4\LouvreBundle\Service
 */
class EmailSending
{

    private $twig;
    private $mailer;

    /**
     * EmailSending constructor.
     * @param \Twig_Environment $twig
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    /**
     * @param Booking $booking
     */


    public function sendEmailFr(Booking $booking)
    {

        $message = \Swift_Message::newInstance()
            ->setSubject('Billetterie du Musée du Louvre')
            ->setFrom('stephaniehoussinparis@gmail.com')
            ->setTo($booking->getEmail())
            ->setCharset('utf-8')
            ->setContentType('text/html');
            $logo = $message->embed(\Swift_Image::fromPath('img/logo.jpg'));
        $message
            ->setBody(
                $this->twig->render('Email/emailFr.html.twig', array(
                    'booking' => $booking,
                    'logo' => $logo)));
        $this->mailer->send($message);
    }

    public function sendEmailEn(Booking $booking)
    {

        $message = \Swift_Message::newInstance()
            ->setSubject('ticketing of Louvre Museum')
            ->setFrom('stephaniehoussinparis@gmail.com')
            ->setTo($booking->getEmail())
            ->setCharset('utf-8')
            ->setContentType('text/html');
        $logo = $message->embed(\Swift_Image::fromPath('img/logo.jpg'));
        $message
            ->setBody(
                $this->twig->render('Email/emailEn.html.twig', array(
                    'booking' => $booking,
                    'logo' => $logo)));
        $this->mailer->send($message);
    }

}