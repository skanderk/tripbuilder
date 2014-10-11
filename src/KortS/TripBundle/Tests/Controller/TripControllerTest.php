<?php

namespace KortS\TripBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TripControllerTest extends WebTestCase
{
    public function testFlights()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/trip/flights/{tripId}');
    }

    public function testAddflight()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/trip/addFlight/{departureAirportId}/{arrivalAirportId}');
    }

    public function testRemoveflight()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/trip/removeFlight/{flightId}');
    }

    public function testRename()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/trip/rename/{tripId}');
    }

}
