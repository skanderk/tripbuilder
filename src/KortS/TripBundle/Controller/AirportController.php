<?php

namespace KortS\TripBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AirportController.
 * Allows to retrieve a list of airports sorted alphabetically.
 *
 * @author skander
 */
class AirportController extends BaseController
{
    
    /**
     *
     * @var array 
     */
    private $parameters;
    
    /**
     *
     * @var array 
     */
    private $airports;

    /**
     * Returns the list of all airports sorted alphabetically.
     * Two parameters can be passed in the request:
     * - s: a starting index.
     * - c: maximum number of airports to be returned.
     * 
     * @return JsonResponse
     */
    public function listAction()
    {
        try {
            $this->collectParameters();
            $this->findAirports();
        
            return $this->listActionResponse();
        } catch (\Exception $e) { // Log exception and return an error response
            return $this->buildErrorResponse($e);
        }
    }
    
    /**
     * Collects and validates request parameters.
     * 
     * @throws \InvalidArgumentException
     */
    private function collectParameters()
    {
        $this->parameters = array();
        
        $this->parameters['offset'] = $this->collectNonNegativeParameter('s');
        $this->parameters['limit'] = $this->collectNonNegativeParameter('c');
    }
    
    /**
     * 
     * @param string $key
     * @return integer
     * @throws \InvalidArgumentException
     */
    private function collectNonNegativeParameter($key)
    {
        $parameter = $this->getRequest()->get($key, null);
        
         if ($parameter != null && ctype_digit($parameter) == false) {
            throw new \InvalidArgumentException(sprintf('Parameter %s must be a non negative integer', $key));
        }
        
        return is_null($parameter) ? $parameter : (int)$parameter;
    }


    /**
     * Finds airports in the database, possibly restricting to some range.
     */
    private function findAirports()
    {
        $repository =  $this->get('doctrine')
                        ->getManager()
                        ->getRepository('KortSTripBundle:Airport');
        
        $this->airports =  $repository->findBy(array(), array('name' => 'ASC'), 
                                            $this->parameters['limit'], $this->parameters['offset']
                                        );
    }
    
    /**
     * Builds listAction() JSON response.
     */
    private function listActionResponse()
    {
        $response = array('status' => 'OK');
        if ($this->parameters['offset'] !== null) {
            $response['start'] = $this->parameters['offset'];
        }
        
        if ($this->parameters['limit'] !== null) {
            $response['count'] = $this->parameters['limit'];
        }
        
        $response['airports'] = array();
        foreach($this->airports as $airport) {
            $response['airports'][] = $airport->toArray();
        }
        
        return new JsonResponse($response);
    }

}
