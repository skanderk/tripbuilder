<?php

namespace KortS\TripBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Trip.
 * A trip has a name and consists of 1 or many flights.
 *
 * @author Skander Kort
 * @package TripBundle
 * 
 * @ORM\Table(name="trip")
 * @ORM\Entity
 */
class Trip
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Flight")
     * @ORM\JoinTable(name="trip_has_flight", joinColumns={@ORM\JoinColumn(name="trip_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="flight_id", referencedColumnName="id")})
     */
    private $flights;

    /**
     * Class constructor. 
     */
    public function __construct()
    {
        $this->flights = new \Doctrine\Common\Collections\ArrayCollection();;
    }
    
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
     * Set name
     *
     * @param string $name
     * @return Trip
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get all the flights of this trip.
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFlights()
    {
        return $this->flights;
    }
    
    /**
     * Adds a new flight to this trip.
     * 
     * @param Flight $flight
     */
    public function addFlight(Flight $flight)
    {
        $this->flights[] = $flight;
        
        return $this;
    }
    
    /**
     * Removes $flight from this trip.
     * 
     * @param Flight $flight
     */
    public function removeFlight(Flight $flight)
    {
        $this->flights->removeElement($flight);
    }
}
