<?php

namespace KortS\TripBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Base class of the trip management API.
 *
 * @author skander
 */
class ApiTestCase extends WebTestCase
{

    /**
     *
     * @var Symfony\Bundle\FrameworkBundle\Client 
     */
    private $client;

    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    /**
     * 
     * @return Symfony\Bundle\FrameworkBundle\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Send a request to server and decode the Json response.
     * 
     * @param string $url
     * @return StdClass
     */
    protected function request($url)
    {
        $this->client->request('GET', $url);
        $json = $this->client->getResponse()->getContent();

        return json_decode($json);
    }

    /**
     * 
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        if (empty($this->entityManager)) {
            $this->entityManager = $this->getClient()->getContainer()->get('doctrine.orm.entity_manager');
        }

        return $this->entityManager;
    }

}