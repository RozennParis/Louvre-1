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
     * @param Request $request
     * @param BookingManager $bookingManager
     * @param BookingPay $bookingPay
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function stepThreeAction(Request $request, BookingManager $bookingManager, BookingPay $bookingPay)
    {
        $booking = $bookingManager->getBooking();
        if($request->isMethod('POST'))
        {
            $transactionId = $bookingPay->bookingPay($booking, $request->get('stripeToken'));
            if(false !== $transactionId)
            {
                $booking->setBookingCode(uniqid());
                $bookingManager->finishBooking($booking);
                $bookingManager->close();
                $this->addFlash('message','your payment has been accepted ! your order is validated !');
                return $this->redirectToRoute("stepFour");
            }else{
                $this->addFlash('message', 'payment error');
            }
        }
        return $this->render(':Louvre:stepThree.html.twig',array('booking'=>$booking));
    }

    /**
     * @Route("/confirmation", name="stepFour")
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stepFourAction(BookingManager $bookingManager)
    {
        $booking = $bookingManager->recBooking();
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

    /**
     * @Route("/cancel", name="cancel")
     * @param BookingManager $bookingManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cancelBooking(BookingManager $bookingManager)
    {
        return $this->redirectToRoute('stepOne');
    }
}