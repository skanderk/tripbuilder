<?php

namespace KortS\TripBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides trip management methods.
 */
class TripController extends BaseController
{
    
    const MAX_TRIP_NAME_LENGTH = 128;

    /**
     * Returns all the flights of trip $tripId.
     * 
     * @param integer $tripId
     */
    public function flightsAction($tripId)
    {
        try {
            $this->assertIsPositiveInteger($tripId, 'Trip Id');
            $flights = $this->findTrip($tripId)->getFlights();

            return $this->flightsActionResponse($tripId, $flights);
        } catch (\Exception $e) {
            return $this->buildErrorResponse($e);
        }
    }

    /**
     * Returns  a trip. Throws an InvalidArgumentException when the trip does not exist.
     * 
     * @param integer $tripId
     * @return KortSTripBundle\Entity\Trip
     * @throws \InvalidArgumenException
     */
    private function findTrip($tripId)
    {
        $trip = $this->getDoctrine()->getManager()->find('KortSTripBundle:Trip', $tripId);

        if (empty($trip)) {
            throw new \InvalidArgumenException('Trip not found');
        }

        return $trip;
    }

    /**
     * Builds flightsAction() JSON response.
     * 
     * @param integer $tripId
     * @param Doctrine\ORM\PersistentCollection $flights
     * @return \Symfony\Component\HttpFoundation\JsonResponse;
     * 
     */
    private function flightsActionResponse($tripId, $flights)
    {
        $response = array(
            'status'  => 'OK',
            'tripId'  => $tripId,
            'flights' => array()
        );

        foreach ($flights as $flight) {
            $response['flights'][] = $flight->toArray();
        }

        return new JsonResponse($response);
    }

    /**
     * Adds a new flight to a trip.
     * 
     * @param integer $tripId
     * @param integer $departureAirportId
     * @param integer $arrivalAirportId
     */
    public function addFlightAction($tripId, $departureAirportId, $arrivalAirportId)
    {
        try {
            $this->assertIsPositiveInteger($tripId, 'Trip Id');
            $this->assertIsPositiveInteger($departureAirportId, 'Departure airport id');
            $this->assertIsPositiveInteger($arrivalAirportId, 'Arrival airport id');

            $trip = $this->findTrip($tripId);
            $newFlight = $this->findFlightByAirports($departureAirportId, $arrivalAirportId);

            $trip->addFlight($newFlight);
            $this->getDoctrine()->getManager()->flush();

            return $this->addFlightResponse($tripId, $newFlight->getId(), $departureAirportId, $arrivalAirportId);
        } catch (\Exception $e) {
            return $this->buildErrorResponse($e);
        }
    }

    /**
     * Returns  a flight from a given airport to some other airport. 
     * Throws an InvalidArgumentException when the flight does not exist.
     * 
     * @param integer $departureAirportId
     * @param integer $arrivalAirportId
     * @return KortSTripBundle\Entity\Flight
     * @throws \InvalidArgumenException
     */
    private function findFlightByAirports($departureAirportId, $arrivalAirportId)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('KortSTripBundle:Flight');

        $flights = $repository->findBy(array(
            'departureAirport' => $departureAirportId,
            'arrivalAirport'   => $arrivalAirportId
            )
        );

        if (empty($flights)) {
            throw new \InvalidArgumentException(sprintf("There are no direct flights from airport %d to airport %d", $departureAirportId, $arrivalAirportId
                )
            );
        }

        // Since Trip builder application does not handle departure and arrival times, there 
        // will be at most one flight from one airport to another.
        return $flights[0];
    }

    /**
     * 
     * @param integer $tripId
     * @param integer $flightId
     * @param integer $departureAirportId
     * @param integer $arrivalAirportId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function addFlightResponse($tripId, $flightId, $departureAirportId, $arrivalAirportId)
    {
        $response = array(
            'status'             => 'OK',
            'tripId'             => $tripId,
            'flightId'           => $flightId,
            'departureAirportId' => $departureAirportId,
            'arrivalAirportId'   => $arrivalAirportId
        );

        return new JsonResponse($response);
    }

    /**
     * Removes a flight from a trip. 
     * Trying to remove a flight that is not part of the trip does not lead to an error.
     * 
     * @param integer $tripId
     * @param integer $flightId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function removeFlightAction($tripId, $flightId)
    {
        try {
            $this->assertIsPositiveInteger($tripId, 'Trip Id');
            $this->assertIsPositiveInteger($flightId, 'Flight Id');

            $trip = $this->findTrip($tripId);
            $flight = $this->findFlight($flightId);
            $trip->removeFlight($flight);
            $this->getDoctrine()->getManager()->flush();

            return $this->removeFlightResponse($tripId, $flightId);
        } catch (\Exception $e) {
            return $this->buildErrorResponse($e);
        }
    }

    /**
     * Returns  a flight. Throws an InvalidArgumentException when the flight does not exist.
     * 
     * @param integer $tripId
     * @return KortSTripBundle\Entity\Flight
     * @throws \InvalidArgumenException
     */
    private function findFlight($flightId)
    {
        $flight = $this->getDoctrine()->getManager()->find('KortSTripBundle:Flight', $flightId);

        if (empty($flight)) {
            throw new \InvalidArgumenException('Flight not found');
        }

        return $flight;
    }

    /**
     * 
     * @param integer $tripId
     * @param integer $flightId
     */
    private function removeFlightResponse($tripId, $flightId)
    {
        $response = array(
            'status'   => 'OK',
            'tripId'   => $tripId,
            'flightId' => $flightId,
        );

        return new JsonResponse($response);
    }

    /**
     * Updates the name of a given trip
     * 
     * @param integer $tripId
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function renameAction($tripId, $name)
    {
        try {
            $this->assertIsPositiveInteger($tripId, 'Trip Id');
            $this->assertIsValidTripName($name);
            $this->findTrip($tripId)->setName($name);
            $this->getDoctrine()->getManager()->flush();

            return $this->renameActionResponse($tripId, $name);
        } catch (\Exception $e) {
            return $this->buildErrorResponse($e);
        }
    }
    
    /**
     * 
     * Asserts that trip name has a valid length.
     * 
     * @param string $name
     * @throws \InvalidArgumentException
     */
    private function assertIsValidTripName($name)
    {
        $l = strlen($name);
        if ($l == 0 || $l > self::MAX_TRIP_NAME_LENGTH) {
            throw new \InvalidArgumentException('Invalid trip name');
        }
    }

    /**
     * 
     * @param integer $tripId
     * @param string $name
     */
    private function renameActionResponse($tripId, $name)
    {
        $response = array(
            'status'  => 'OK',
            'tripId'  => $tripId,
            'newName' => $name,
        );

        return new JsonResponse($response);
    }

}
