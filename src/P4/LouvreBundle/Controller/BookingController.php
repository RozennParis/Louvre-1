<?php

namespace P4\LouvreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookingController extends Controller
{
    public function homeAction()
    {
    return $this->render('P4LouvreBundle:Home:home.html.twig');
    }
}