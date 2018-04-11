<?php
namespace Tests\P4\LouvreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class LouvreControllerTest extends WebTestCase
{

    // Verification que le code status de la reponse Http est bien 200
    public function testStepOneIsUp()
    {
        $client = self::createClient();
        $client->request('GET', '/en/');
        static::assertSame(
            200, $client->getResponse()->getStatusCode()
        );
    }

    public function testStepOneTitle()
    {
        // chercher s'il y a 1 h1 dans la page
        $client = static::createClient();
        $client->request('GET', '/en/');

        $this->assertSame(1, $client->filter('h1')->count());
    }

    public function testFormBookingValid()
    {
        $client = static::createClient();
        $crawler =$client->request('GET', '/en/');


        $formBooking = $crawler->selectButton('next')->form();

        $formBooking['booking[visitDate]'] = '01/06/2018';
        $formBooking['booking[nbTickets]'] = 1;
        $formBooking['booking[ticketType]'] = true;
        $formBooking['booking[email][first]'] = 'stephanie.houssin@gmx.fr';
        $formBooking['booking[email][second]'] = 'stephanie.houssin@gmx.fr';

        $crawler = $client->submit($formBooking);
        dump($client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect());
        //$this->assertTrue($client->getResponse()->isRedirect('/en/tickets'));
        $crawler = $client->followRedirect();

        $this->assertContains("your reservation", $client->getResponse()->getContent());

        $formTickets = $crawler->selectButton('next')->form();

        $formTickets['tickets_booking[tickets][0][firstName]'] = 'stephanie';
        $formTickets['tickets_booking[tickets][0][lastName]'] = 'Houssin';
        $formTickets['tickets_booking[tickets][0][birthDate]'] = '17/07/1976';
        $formTickets['tickets_booking[tickets][0][country]'] = 'FR';
        $formTickets['tickets_booking[tickets][0][reducedPrice]'] = 1;

        $crawler = $client->submit($formTickets);

        $this->assertTrue($client->getResponse()->isRedirect('/en/summary'));
        $crawler = $client->followRedirect();

        $this->assertContains("your reservation", $client->getResponse()->getContent());

    }
}