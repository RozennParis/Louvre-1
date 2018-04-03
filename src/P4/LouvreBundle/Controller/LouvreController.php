<?php
namespace P4\LouvreBundle\Controller;

use P4\LouvreBundle\Service\PriceCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use P4\LouvreBundle\Form\BookingType;
use P4\LouvreBundle\Form\TicketsBookingType;
use P4\LouvreBundle\Manager\BookingManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function stepOneAction(Request $request,BookingManager $bookingManager)
    {
        $booking = $bookingManager->initBooking();
        $form = $this->createForm(BookingType::class,$booking);

        if($request->isMethod('POST') &&  $form->handleRequest($request)->isValid())
        {
            $bookingManager->startBooking($booking);

            return $this->redirectToRoute('stepTwo');
        }
        return $this->render(':Louvre:stepOne.html.twig',array('form' => $form->createView(),
        ));
    }
    /**
     * @Route("/informations", name="stepTwo")
     * @param Request $request
     * @param PriceCalculation $priceCalculation
     * @param BookingManager $bookingManager
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function stepTwoAction(Request $request, PriceCalculation $priceCalculation, BookingManager $bookingManager)
    {
        $booking = $bookingManager->getBooking();
        $form = $this->createForm(TicketsBookingType::class,$booking);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $priceCalculation->PriceCalculation($booking);
            return $this->redirectToRoute('stepThree');
        }
        return $this->render(':Louvre:stepTwo.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/summary", name="stepThree")
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function stepThreeAction(Request $request,BookingManager $bookingManager)
    {
        $booking = $bookingManager->getBooking();
        $booking->setBookingCode(uniqid());
        return $this->render(':Louvre:stepThree.html.twig',array('booking'=>$booking));
    }

    /**
     * @Route("/checkout", name="checkout")
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return RedirectResponse
     * @throws \Exception
     */

    public function checkoutAction(Request $request,BookingManager $bookingManager)
    {
        $booking = $bookingManager->getBooking();
         \Stripe\Stripe::setApiKey("sk_test_a2vkPyuLgme3hbfLJ0b0YtTx");

        $token = $_POST['stripeToken'];

        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $booking->getTotalPrice() * 100,
                "currency" => "eur",
                "source" => $token,
                "description" => "ticketing"
            ));

            $bookingManager->finishBooking($booking);
            return $this->redirectToRoute("stepFour");

        } catch (\Stripe\Error\Card $e) {

            $this->addFlash("error", "Votre paiement n'a pas abouti ");
            return $this->redirectToRoute("stepThree");
        }
    }

    /**
     * @Route("/recap", name="stepFour")
     * @param Request $request
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function stepFourAction(Request $request, BookingManager $bookingManager, SessionInterface $session)
    {

        $booking = $bookingManager->getBooking();
        $session->clear();
        return $this->render(':Louvre:stepFour.html.twig',array('booking'=> $booking));
    }
}