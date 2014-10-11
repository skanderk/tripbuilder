<?php

namespace KortS\TripBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @author Skander Kort
 * @package TripBundle
 * 
 * @ORM\Table(name="city")
 * @ORM\Entity
 */
class City
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=64)
     */
    private $country;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Airport", mappedBy="city")
     */
    private $airports;

    /**
     * Class constructor. 
     */
    public function __construct()
    {
        $this->airports = new \Doctrine\Common\Collections\ArrayCollection();;
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
     * @return City
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
     * Set country
     *
     * @param string $country
     * @return City
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get all city's airports.
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAirports()
    {
        return $this->airports;
    }
    
    /**
     * Adds a new airport to this city.
     * 
     * @param Airport $airport
     */
    public function addAirport(Airport $airport)
    {
        $this->airports[] = $airport;
        
        return $this;
    }
    
    /**
     * Removes $airport from this city's airports.
     * 
     * @param Airport $airport
     */
    public function removeAirport(Airport $airport)
    {
        $this->airports->removeElement($airport);
    }
}
