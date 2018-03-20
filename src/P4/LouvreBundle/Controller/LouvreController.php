<?php
namespace P4\LouvreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\LouvreBundle\Entity\Booking;
use P4\LouvreBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use P4\LouvreBundle\Form\BookingType;
use P4\LouvreBundle\Form\TicketsBookingType;

/**
 * Class LouvreController
 * @package P4\LouvreBundle\Controller
 */
class LouvreController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepageAction()
    {
        return $this->render('P4LouvreBundle:LouvreViews:homepage.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function stepOneAction(Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class,$booking);

        if($request->isMethod('POST') &&  $form->handleRequest($request)->isValid())
        {
            /*$nbTickets = $form->get('nbTickets')->getData();
            for($i = 0;$i< $nbTickets; $i++)
            {
                $ticket = new Ticket();
                $booking->addTicket($ticket);
            }
            for($i = 0;$i> $nbTickets;$i++)
            {
                $ticket = $booking->getTickets()->last();
                $booking->removeTicket($ticket);
            }*/
            while(count($booking->getTickets())< $booking->getNbTickets())
            {
                $ticket = new Ticket();
                $booking->addTicket($ticket);
            }
            while(count($booking->getTickets()) > $booking->getNbTickets())
            {
                $ticket = $booking->getTickets()->last();
                $booking->removeTicket($ticket);
            }

            $this->get('session')->set('booking',$booking);
            return $this->redirectToRoute('p4_louvre_stepTwo');
        }
        return $this->render('P4LouvreBundle:LouvreViews:stepOne.html.twig',array('form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function stepTwoAction(Request $request)
    {
        $booking = $this->get('session')->get('booking');
        if(!$booking)
        {
            throw new \Exception();
        }

        $form = $this->createForm(TicketsBookingType::class,$booking);

        if($form->handleRequest($request)->isValid())
        {
            $this->get('session')->set('booking',$booking);
            return $this->redirectToRoute('p4_louvre_stepThree');
        }
        return $this->render('P4LouvreBundle:LouvreViews:stepTwo.html.twig', array('form' => $form->createView()));
    }

    public function stepThreeAction(Request $request)
    {
        $booking = $this->get('session')->get('booking');
        return $this->render('P4LouvreBundle:LouvreViews:stepThree.html.twig',array('booking'=>$booking));
    }

}