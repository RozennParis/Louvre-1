<?php
namespace P4\LouvreBundle\Controller;

use P4\LouvreBundle\Service\PriceCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\LouvreBundle\Entity\Booking;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use P4\LouvreBundle\Form\BookingType;
use P4\LouvreBundle\Form\TicketsBookingType;
use P4\LouvreBundle\Manager\BookingManager;

/**
 * Class LouvreController
 * @package P4\LouvreBundle\Controller
 */
class LouvreController extends Controller
{

    /**
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function stepOneAction(Request $request,BookingManager $bookingManager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class,$booking);

        if($request->isMethod('POST') &&  $form->handleRequest($request)->isValid())
        {
            $bookingManager->startBooking($booking);
            $this->get('session')->set('booking',$booking);
            return $this->redirectToRoute('p4_louvre_stepTwo');
        }
        return $this->render('P4LouvreBundle:LouvreViews:stepOne.html.twig',array('form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param PriceCalculation $priceCalculation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function stepTwoAction(Request $request, PriceCalculation $priceCalculation)
    {

        $booking = $this->get('session')->get('booking');

        $form = $this->createForm(TicketsBookingType::class,$booking);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $priceCalculation->PriceCalculation($booking);
            $this->get('session')->set('booking',$booking);
            return $this->redirectToRoute('p4_louvre_stepThree');
        }
        return $this->render('P4LouvreBundle:LouvreViews:stepTwo.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function stepThreeAction(Request $request)
    {
        $booking = $this->get('session')->get('booking');
        $booking->setBookingCode(uniqid());
        return $this->render('P4LouvreBundle:LouvreViews:stepThree.html.twig',array('booking'=>$booking));
    }



}