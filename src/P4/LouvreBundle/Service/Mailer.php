<?php
namespace P4\LouvreBundle\Service;
use P4\LouvreBundle\Entity\Booking;


/**
 * Class Mailer
 * @package P4\LouvreBundle\Service
 */
class Mailer
{

    private $twig;
    private $mailer;

    /**
     * Mailer constructor.
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

    public function sendEmail(Booking $booking)
    {

        $message = \Swift_Message::newInstance()
            ->setSubject('Billetterie du Musée du Louvre')
            ->setFrom('stephaniehoussinparis@gmail.com')
            ->setTo($booking->getEmail())
            ->setCharset('utf-8')
            ->setContentType('text/html');
            $icon = $message->embed(\Swift_Image::fromPath('img/icon.png'));
        $message
            ->setBody(
                $this->twig->render('Email/confirmation.html.twig', array(
                    'booking' => $booking,
                    'icon' => $icon)));
        $this->mailer->send($message);
    }


}