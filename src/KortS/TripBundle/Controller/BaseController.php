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
        
        return new JsonResponse($response);
    }
}