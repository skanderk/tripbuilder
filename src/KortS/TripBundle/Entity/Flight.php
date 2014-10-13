<?php

namespace KortS\TripBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Describes a single flight.
 * A flight has a departure airport and an arrival airport. 
 * A more realistic flight entity will also have a departure date and an arrival date.
 *
 * @author Skander Kort
 * @package TripBundle
 * 
 * @ORM\Table(name="flight")
 * @ORM\Entity
 */
class Flight
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var KortSTripBundle\Entity\Airport
     * 
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumn(name="departure_airport_id", referencedColumnName="id")
     */
    private $departureAirport;
    
    /**
     * @var KortSTripBundle\Entity\Airport
     * 
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumn(name="arrival_airport_id", referencedColumnName="id")
     */
    private $arrivalAirport;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set the departure airport for this flight.
     * 
     * @param \KortS\TripBundle\Entity\Airport $airport
     * @return \KortS\TripBundle\Entity\Flight
     */
    public function setDepartureAirport(Airport $airport)
    {
        $this->departureAirport = $airport;
        
        return $this;
    }
    
    /**
     * 
     * @return \KortS\TripBundle\Entity\Airport
     */
    public function getDepartureAirport()
    {
        return $this->departureAirport;
    }
    
    /**
     * Set the arrival airport for this flight.
     * 
     * @param \KortS\TripBundle\Entity\Airport $airport
     * @return \KortS\TripBundle\Entity\Flight
     */
    public function setArrivalAirport(Airport $airport)
    {
        $this->arrivalAirport = $airport;
        
        return $this;
    }
    
    /**
     * Get the arrival airport of this flight.
     * 
     * @return \KortS\TripBundle\Entity\Airport
     */
    public function getArrivalAirport()
    {
        return $this->arrivalAirport;
    }
    
    /**
     * Converts a flights to an array.
     * 
     * @return array
     */
    public function toArray()
    {
        return array(
            'id'                => $this->getId(),
            'departureAirport'  => $this->getDepartureAirport()->toArray(),
            'arrivalAirport'    => $this->getArrivalAirport()->toArray()
        );
    }
}
