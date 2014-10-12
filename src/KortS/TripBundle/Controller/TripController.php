<?php

namespace KortS\TripBundle\Controller;

use \Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;


class TripController extends BaseController
{

    /**
     * Returns all the flights of trip $tripId.
     * 
     * @param integer $tripId
     */
    public function flightsAction($tripId)
    {
        try {
            $this->assertIsNonNegativeInteger($tripId, 'Trip Id has to be non negative');
            $flights = $this->findFlights($tripId);
            
            return $this->flightsActionResponse($tripId, $flights);
            
        } catch (\Exception $e) {
             return $this->buildErrorResponse($e);
        }
    }
    
    /**
     * Checks if $value is a non negative integer.
     * 
     * @param integer $value
     * @param string $errorMessage
     * @throws \InvalidArgumenException
     */
    private function assertIsNonNegativeInteger($value, $errorMessage)
    {
        if (false == ctype_digit($value)) {
            throw new \InvalidArgumenException($errorMessage);
        }
    }
    
    /**
     * Returns the flights of a trip. Throws an InvalidArgumentException when the trip
     * cannot be found.
     * 
     * @param integer $tripId
     * @return \Doctrine\Common\Collections\ArrayCollection
     * @throws \InvalidArgumenException
     */
    private function findFlights($tripId)
    {
         $trip = $this->get('doctrine')->getManager()->find('KortSTripBundle:Trip', $tripId);
         
        if (empty($trip)) {
            throw new \InvalidArgumenException('Trip not found');
        }
        
        return $trip->getFlights();
    }

    /**
     * Builds flightsAction() JSON response.
     * 
     * @param integer $tripId
     * @param \Doctrine\Common\Collections\ArrayCollection
     * @return \Symfony\Component\HttpFoundation\JsonResponse;
     * 
     */
    private function flightsActionResponse($tripId, ArrayCollection $flights)
    {
         $response = array(
             'status' => 'OK',
             'tripId'   => $tripId,
             'flights'  => array()
            );
         
         foreach($flights as $flight) {
             $response['flights'][] = $flight->toArray();
         }
         
         return new JsonResponse($response);
    }

    public function addFlightAction($departureAirportId, $arrivalAirportId)
    {
        
    }

    public function removeFlightAction($flightId)
    {
        
    }

    public function renameAction($tripId)
    {
        
    }

}
