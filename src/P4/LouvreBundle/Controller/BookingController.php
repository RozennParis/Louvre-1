<?php

namespace P4\LouvreBundle\Controller;

use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends Controller
{
    public function homepageAction()
    {
        return $this->render('P4LouvreBundle:Booking:homepage.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ticketingAction(Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class,$booking);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
            {
                $em= $this->getDoctrine()->getManager();
                $em->persist($booking);
                $em->flush();

                $request->getSession()->getFlashBag()->add('commande','ticketing ok');
                return $this->redirectToRoute('p4_louvre_visitorInfo',array('id' => $booking->getId()));
            }
                return $this->render('P4LouvreBundle:Booking:ticketing.html.twig',array('form' => $form->createView(),
        ));
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