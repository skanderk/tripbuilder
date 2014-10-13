<?php

namespace KortS\TripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Base class for the trip builder controllers.
 *
 * @author skander
 */
class BaseController extends Controller
{
    /**
     * Builds a JSON error response that will be returned to the client.
     * Only invalid argument exceptions are reported back to the client.
     * 
     * @param Exception $e
     */
    protected function buildErrorResponse(\Exception $e)
    {
        $response = array('status' => 'ERROR');
        $response['message'] = ($e instanceof \InvalidArgumentException) ? $e->getMessage() : 'Internal error';
        
        $this->get('logger')->warn((string)$e);
        
        return new JsonResponse($response);
    }
    
    /**
     * Checks if $value is a positive integer.
     * 
     * @param integer $value
     * @param string $name
     * @throws \InvalidArgumenException
     */
    protected function assertIsPositiveInteger($value, $name)
    {
        if (false == ctype_digit($value) || $value == 0) {
            throw new \InvalidArgumentException(sprintf("%s has to be a positive integer", $name));
        }
    }
}