<?php
namespace P4\LouvreBundle\Controller;

use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Entity\Ticket;
use P4\LouvreBundle\Form\BookingType;
use P4\LouvreBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
class BookingController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        // Appel de la vue de la page d'accueil
        return $this->render('P4LouvreBundle:Booking:homepage.html.twig');
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    /**
     * @Route("/ticketing", name="ticketing")
     */
    public function ticketingAction(Request $request)
    {
        //1ere etape = formulaire booking
        //Appel du manager
        //creation du formulaire
        //verifications des donnees
        // si OK -> on dirige vers la 2eme etape
        $booking = new Booking();
        $form = $this->createForm(BookingType::class,$booking);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em= $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();
            $request->getSession();
            return $this->redirectToRoute('visitorInfo',array('id' => $booking->getId()));
        }
        return $this->render('P4LouvreBundle:Booking:ticketing.html.twig',array('form' => $form->createView(),
        ));
    }
    /**
     * @Route("/visitorInfo", name="visitorInfo")
     */
    public function visitorInfoAction(Request $request)
    {
        //2eme etape = formulaire Ticket
        //Appel du manager
        //creation du formulaire
        //verifications des donnees
        // si OK -> on dirige vers la 3eme etape
        $ticket = new Ticket();
        $form= $this->createForm(TicketType::class,$ticket);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            $request->getSession();
            return $this->redirectToRoute('orderSummary',array('id'=>$ticket->getId()));
        }
        return $this->render('P4LouvreBundle:Booking:visitorInfo.html.twig',array('form'=> $form->createView(),));
    }
    /**
     * @Route("/orderSummary", name="orderSummary")
     */
    public function orderSummaryAction()
    {
        // 3eme etape = Appel de la vue de la commande = page recapitulative
        //Appel du manager
        // Appel de la vue de la 3eme etape
        return $this->render('P4LouvreBundle:Booking:orderSummary.html.twig');
    }

}