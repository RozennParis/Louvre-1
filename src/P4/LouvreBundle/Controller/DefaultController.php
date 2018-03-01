<?php

namespace P4\LouvreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('P4LouvreBundle:Default:index.html.twig');
    }
}
