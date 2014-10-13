<?php

namespace KortS\TripBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AirportControllerTest extends WebTestCase
{
    /**
     *
     * @var Symfony\Bundle\FrameworkBundle\Client 
     */
    private $client;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->client = static::createClient();
    }


    /**
     * ListAction() returns an OK status and the correct number of airports.
     */
    public function testList()
    {
        // Test
        $response = $this->request('/airport/list');
        
        // Validate
        $this->assertEquals('OK', $response->status);
        $this->assertCount(8, $response->airports);
        
    }
    
    /**
     * ListAction() returns the requested number of airports.
     */
    public function testListCount()
    {
        // Test
        $response = $this->request('/airport/list?c=3');
        
        // Validate
        $this->assertCount(3, $response->airports);
    }
    
    /**
     * ListAction() starts at the right index when parameter s is specified.
     */
    public function testListStart()
    {
        // Test
        $response = $this->request('/airport/list?s=1');
        
        // Validate
        $this->assertEquals('YTZ', $response->airports[0]->code);
    }
    
    /**
     * ListAction() returns an alphabetically sorted list of airports.
     */
    public function testListSort()
    {
        // Test
        $response = $this->request('/airport/list?c=2');
        
        // Validate
        $this->assertLessThanOrEqual($response->airports[0]->name, $response->airports[0]->name);
    }
    
    /**
     * ListAction() returns an error when one of the parameters is not valid.
     */
    public function testListError()
    {
        // Test
        $response = $this->request('/airport/list?c=-12');
        
        // Validate
        $this->assertEquals('ERROR', $response->status);
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

}
