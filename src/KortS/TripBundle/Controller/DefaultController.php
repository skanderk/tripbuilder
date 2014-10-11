<?php

namespace KortS\TripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KortSTripBundle:Default:index.html.twig', array('name' => $name));
    }
}
