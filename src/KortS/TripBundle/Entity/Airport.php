<?php

namespace KortS\TripBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * The Airport entity. 
 *
 * @author Skander Kort
 * @package TripBundle 
 *
 * @ORM\Table(name="airport")
 * @ORM\Entity
 */
class Airport
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
     * IATA 3-digits airport code.
     * 
     * @var string
     *
     * @ORM\Column(name="iata_code", type="string", length=3)
     */
    private $iataCode;

    /**
     * Airport's full name.
     * 
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     *
     * @var KortS\TripBundle\Entity\City
     * 
     * @ORM\ManyToOne(targetEntity="City", inversedBy="airports")
     */
    private $city;

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
     * Set IATA code
     *
     * @param string $code
     * @return Airport
     */
    public function setIataCode($code)
    {
        $this->iataCode = $code;

        return $this;
    }

    /**
     * Get IATA code
     *
     * @return string 
     */
    public function getIataCode()
    {
        return $this->iataCode;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Airport
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
     * Set city
     *
     * @param City $city
     * @return Airport
     */
    public function setCity(City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Converts an airport to an associative array.
     */
    public function toArray()
    {
        return array(
            'id'   => $this->getId(),
            'name' => $this->getName(),
            'code' => $this->getIataCode(),
            'city' => $this->getCity()->getName()
        );
    }
}
