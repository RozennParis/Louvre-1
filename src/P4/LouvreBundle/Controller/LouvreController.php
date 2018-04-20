<?php
namespace P4\LouvreBundle\Controller;
use P4\LouvreBundle\Service\BookingPay;
use P4\LouvreBundle\Service\PriceCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use P4\LouvreBundle\Form\BookingType;
use P4\LouvreBundle\Form\TicketsBookingType;
use P4\LouvreBundle\Manager\BookingManager;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/{_locale}", defaults={"_locale" : "en"}, requirements={"_locale": "en|fr"})
 * Class LouvreController
 * @package P4\LouvreBundle\Controller
 */
class LouvreController extends Controller
{
    /**
     * @Route("/", name="stepOne")
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function stepOneAction(Request $request,BookingManager $bookingManager)
    {
        $booking = $bookingManager->initBooking();
        $form = $this->createForm(BookingType::class,$booking);
        // if($request->isMethod('POST') &&  $form->handleRequest($request)->isValid())
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $bookingManager->startBooking($booking);
            return $this->redirectToRoute('stepTwo');
        }
        return $this->render(':Louvre:stepOne.html.twig',array('form' => $form->createView(),
        ));
    }
    /**
     * @Route("/tickets", name="stepTwo")
     * @param Request $request
     * @param PriceCalculation $priceCalculation
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function stepTwoAction(Request $request, PriceCalculation $priceCalculation, BookingManager $bookingManager)
    {
        $booking = $bookingManager->getBooking();
        $form = $this->createForm(TicketsBookingType::class,$booking);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $priceCalculation->priceCalculation($booking);
            return $this->redirectToRoute('stepThree');
        }
        return $this->render(':Louvre:stepTwo.html.twig', array('form' => $form->createView(),'booking'=> $booking));
    }
    /**
     * @Route("/summary", name="stepThree")
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function stepThreeAction(BookingManager $bookingManager)
    {
        $booking = $bookingManager->getBooking();
        $booking->setBookingCode(uniqid());
        return $this->render(':Louvre:stepThree.html.twig',array('booking'=>$booking));
    }
    /**
     * @Route("/checkout", name="checkout")
     * @param Request $request
     * @param BookingManager $bookingManager
     * @param BookingPay $bookingPay
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function checkoutAction(Request $request, BookingManager $bookingManager,BookingPay $bookingPay)
    {
        $booking = $bookingManager->getBooking();
        if($request->isMethod('POST'))
        {
            $transactionId = $bookingPay->bookingPay($booking, $request->get('stripeToken'));
            if(false !== $transactionId)
            {
                $bookingManager->finishBooking($booking);
                $this->get('session')->set('id',$booking->getId());
                //$this->addFlash("success","Le paiement a bien été effectué !");
                $bookingManager->close();
            }
        }
        return $this->redirectToRoute("stepFour", array(
            'id' => $booking->getId()));
    }
    /**
     * @Route("/recap/{id}", name="stepFour" , requirements={"id" = "\d+"} )
     * @param BookingManager $bookingManager
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function stepFourAction(BookingManager $bookingManager, $id)
    {
        $booking = $bookingManager->recBooking($id);
        return $this->render(':Louvre:stepFour.html.twig',array(
            'booking'=> $booking ));
    }
    /**
     * @Route("/cgv", name="cgv")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgv()
    {
        return $this->render(':Louvre:cgv.html.twig');
    }
}