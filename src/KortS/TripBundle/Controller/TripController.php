<?php

namespace KortS\TripBundle\Controller;


class TripController extends BaseController
{

    public function flightsAction($tripId)
    {
        return $this->render('KortSTripBundle:Trip:flights.html.twig', array(
                // ...
            ));
    }

    public function addFlightAction($departureAirportId, $arrivalAirportId)
    {
        return $this->render('KortSTripBundle:Trip:addFlight.html.twig', array(
                // ...
            ));
    }

    public function removeFlightAction($flightId)
    {
        return $this->render('KortSTripBundle:Trip:removeFlight.html.twig', array(
                // ...
            ));
    }

    public function renameAction($tripId)
    {
        return $this->render('KortSTripBundle:Trip:rename.html.twig', array(
                // ...
            ));
    }

}
