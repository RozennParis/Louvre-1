<?php
namespace Tests\P4\LouvreBundle\Controller;


use P4\LouvreBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class LouvreControllerTest extends WebTestCase
{

    // test premier step
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }
    public function testFirstStepIsUp()
    {
        $this->client->request('GET', '/fr/');
        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }
    // test fonctionnement sur le nombre de billet d'une commande
    public function testBookingNbTickets()
    {
        $booking = new Booking();
        $booking ->setNbTickets(2);
        $result = $booking->getNbTickets();
        $this->assertEquals(2, $result);
    }

    // test commande complète jusqu'au paiement

    public function testFormBookingValid()
    {
        $client = static::createClient();
        $crawler =$client->request('GET', '/fr/');

        $formBooking = $crawler->selectButton('submit')->form();

        $formBooking['booking[visitDate]'] = '08/06/2018';
        $formBooking['booking[nbTickets]'] = 2;
        $formBooking['booking[ticketType]'] = 1;
        $formBooking['booking[email][first]'] = 'stephanie.houssin@gmx.fr';
        $formBooking['booking[email][second]'] = 'stephanie.houssin@gmx.fr';

        $crawler = $client->submit($formBooking);

        $this->assertTrue($client->getResponse()->isRedirect('/fr/tickets'));

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains(" date de naissance")')->count());

        $formTickets = $crawler->selectButton('submit')->form();

        $formTickets['tickets_booking[tickets][0][firstName]'] = 'stephanie';
        $formTickets['tickets_booking[tickets][0][lastName]'] = 'Houssin';
        $formTickets['tickets_booking[tickets][0][birthDate][day]'] = 22;
        $formTickets['tickets_booking[tickets][0][birthDate][month]'] = 05;
        $formTickets['tickets_booking[tickets][0][birthDate][year]'] = 1956;
        $formTickets['tickets_booking[tickets][0][country]'] = 'FR';
        $formTickets['tickets_booking[tickets][0][reducedPrice]'] = 1;

        $formTickets['tickets_booking[tickets][1][firstName]'] = 'Enzo';
        $formTickets['tickets_booking[tickets][1][lastName]'] = 'Houssin';
        $formTickets['tickets_booking[tickets][1][birthDate][day]'] = 07;
        $formTickets['tickets_booking[tickets][1][birthDate][month]'] = 11;
        $formTickets['tickets_booking[tickets][1][birthDate][year]'] = 2012;
        $formTickets['tickets_booking[tickets][1][country]'] = 'FR';

        $crawler = $client->submit($formTickets);

        $this->assertTrue($client->getResponse()->isRedirect('/fr/summary'));

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains(" Code de réservation ")')->count());

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

 // Test sur le changement de langue
    public function testSiteTransInFrench()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/');
        $link = $crawler->selectLink('FR')->link();
        $crawler = $client->click($link);
        $this->assertSame(1, $crawler->filter('html:contains("MUSEE DU LOUVRE")')->count());
    }
}