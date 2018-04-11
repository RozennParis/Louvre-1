<?php
namespace Tests\P4\LouvreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LouvreControllerTest extends WebTestCase
{
    //private $client = null;
    private $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = static::createClient();
    }

    // Verification que le code status de la reponse Http est bien 200
    public function testStepOneIsUp()
    {
        $this->client->request('GET', '/en/');
        static::assertSame(
            200,$this->client->getResponse()->getStatusCode()
        );
    }
    public function testStepOneTitle()
    {
        // chercher s'il y a 1 h1 dans la page
       // $client = static::createClient();

        $crawler= $this->client->request('GET', '/en/');

        $this->assertSame(1,$crawler->filter('h1')->count());
    }

    public function testFormBookingValid()
    {
        $crawler = $this->client->request('GET', '/en/');
        $this->client->followRedirects();

        $form = $crawler->selectButton('next')->form();

        $form['booking[visitDate]'] = '01/06/2018';
        $form['booking[nbTickets]'] = 1;
        $form['booking[ticketType]'] = true;
        $form['booking[email]'] = 'stephanie.houssin@gmx.fr';

        $crawler = $this->client->submit($form);
        //$this->assertTrue($this->client->getResponse()->isRedirect('/en/tickets'));
        $this->assertContains("old", $this->client->getResponse()->getContent());
        //$this->assertTrue($client->getResponse()->isRedirect());
        //$this->assertSame(1, $crawler->filter('html:contains("your reservation")')->count());
    }
    public function testFirstFormTicketValid()
    {
         $this->testFormBookingValid();

         $crawler = $this->client->request('GET', '/en/tickets');
        //$this->client->followRedirects();
         $form = $crawler->selectButton('next')->form();
         $form['tickets_booking[tickets][0][firstName]'] = 'stephanie';
         $form['tickets_booking[tickets][0][lastName]'] = 'Houssin';
         $form['tickets_booking[tickets][0][birthDate]'] = '17/07/1976';
         $form['tickets_booking[tickets][0][country]'] = 'FR';
         $form['tickets_booking[tickets][0][reducedPrice]'] = 1;

         $crawler = $this->client->submit($form);

         //$this->assertTrue($client->getResponse()->isRedirect('/en/summary'));

        $this->assertContains("your reservation", $this->client->getResponse()->getContent());
    }
}