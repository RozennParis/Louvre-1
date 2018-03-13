<?php

namespace P4\LouvreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookingController extends Controller
{
    public function homepageAction()
    {
        return $this->render('P4LouvreBundle:Booking:homepage.html.twig');
    }
    public function ticketingAction()
    {
        return $this->render('P4LouvreBundle:Booking:ticketing.html.twig');
    }
    public function visitorInfoAction()
    {
        return $this->render('P4LouvreBundle:Booking:visitorInfo.html.twig');
    }
    public function orderSummaryAction()
    {
        return $this->render('P4LouvreBundle:Booking:orderSummary.html.twig');
    }
    public function orderConfirmationAction()
    {
        return $this->render('P4LouvreBundle:Booking:orderConfirmation.html.twig');
    }
}