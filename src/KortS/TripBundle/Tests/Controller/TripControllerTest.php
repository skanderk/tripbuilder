<?php

namespace KortS\TripBundle\Tests\Controller;

use KortS\TripBundle\Tests\ApiTestCase;
use KortS\TripBundle\Entity\Trip;

class TripControllerTest extends ApiTestCase
{

    const TEST_TRIP_NAME = 'TestTrip';
    const TEST_TRIP_NEW_NAME = 'My trip new name';

    /**
     *
     * @var KortS\TripBundle\Entity\Trip 
     */
    private $trip;

    public function setUp()
    {
        parent::setUp();
        $this->createTestTrip();
    }

    /**
     * Creates a new test trip and persists it in the database.
     */
    private function createTestTrip()
    {
        $this->trip = new Trip();
        $this->trip->setName(self::TEST_TRIP_NAME);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($this->trip);
        $entityManager->flush();
    }

    /**
     * Check addFlightAction() response.
     */
    public function testAddFlightResponse()
    {
        // Test : add a flight from Montreal (YUL) to New York (JFK)
        $tripId = $this->trip->getId();
        $addResponse = $this->request("/trip/addFlight/$tripId/d/1/a/4");

        // Validate call response
        $this->assertEquals('OK', $addResponse->status);
        $this->assertEquals($tripId, $addResponse->tripId);
        $this->assertEquals(1, $addResponse->departureAirportId);
        $this->assertEquals(4, $addResponse->arrivalAirportId);
    }

    /**
     * Check addFlightAction() actually adds flights to the test trip.
     */
    public function testAddFlightAdded()
    {
        // Test : add a flight from Paris (CDG) to Montreal (YUL) 
        $tripId = $this->trip->getId();
        $this->request("/trip/addFlight/$tripId/d/6/a/1");

        // Check that the flight has been added
        $response = $this->request("/trip/flights/$tripId");
        $this->assertCount(1, $response->flights);
        $this->assertEquals(6, $response->flights[0]->departureAirport->id);
        $this->assertEquals(1, $response->flights[0]->arrivalAirport->id);
    }

    /**
     * Check that addFlightAction() returns an error when no flight exists from the
     * departure airport to the arrival one.
     */
    public function testAddFlightNoDirectFlight()
    {
        // Test : try to add a flight from New York (LGA) to San Francisco (SFO) 
        $tripId = $this->trip->getId();
        $response = $this->request("/trip/addFlight/$tripId/d/5/a/8");

        // Validate
        $this->assertEquals('ERROR', $response->status);
    }

    /**
     * Flights action returns all the flights in a trip.
     */
    public function testFlights()
    {
        // Test: add a flight from Montreal (YUL) to New York (JFK) and
        // a flight from New York (JFK) to San francisco (SFO).
        $tripId = $this->trip->getId();
        $this->request("/trip/addFlight/$tripId/d/1/a/4");
        $this->request("/trip/addFlight/$tripId/d/4/a/8");

        $response = $this->request("/trip/flights/$tripId");

        // Validate
        $this->assertEquals('OK', $response->status);
        $this->assertCount(1, $response->flights);
    }

    /**
     * Check that removeFlightAction() actually removes a flight from the test trip.
     */
    public function testRemoveflight()
    {
        // Test: add a flight from Montreal (YUL) to New York (JFK) and
        // a flight from New York (JFK) to Paris (CDG) then
        // remove the flight from YUL to JFK.
        $tripId = $this->trip->getId();
        $addResponse = $this->request("/trip/addFlight/$tripId/d/1/a/4");
        $this->request("/trip/addFlight/$tripId/d/4/a/6");

        $removeResponse = $this->request("/trip/removeFlight/$tripId/f/$addResponse->flightId");

        // Validate
        $this->assertEquals('OK', $removeResponse->status);

        $response = $this->request("/trip/flights/$tripId");
        $this->assertCount(1, $response->flights);
        $this->assertEquals(4, $response->flights[0]->departureAirport->id);
        $this->assertEquals(6, $response->flights[0]->arrivalAirport->id);
    }

    /**
     * check that renameAction() updates the name of the trip.
     */
    public function testRename()
    {
        // Test
        $tripId = $this->trip->getId();
        $response = $this->request("/trip/rename/$tripId/n/" . self::TEST_TRIP_NEW_NAME);

        // Validate
        $this->assertEquals('OK', $response->status);
        $this->assertEquals(self::TEST_TRIP_NEW_NAME, $response->newName);

        $entityManager = $this->getEntityManager(); // Force entity manager to get the trip from DB
        $entityManager->detach($this->trip);
        $this->trip = $entityManager->find('KortSTripBundle:Trip', $tripId);
        $this->assertEquals(self::TEST_TRIP_NEW_NAME, $this->trip->getName());
    }

    /**
     * Deletes the test trip from the database and clears the entity manager.
     */
    public function tearDown()
    {
        $this->deleteTestTrip();
        $this->getEntityManager()->clear();

        parent::tearDown();
    }

    /**
     * Deletes the test trip from the database.
     */
    private function deleteTestTrip()
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($this->trip);
        $entityManager->flush();
    }

}
