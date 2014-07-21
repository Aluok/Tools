<?php

namespace SSS\AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SSS\AccueilBundle\Divers\XML;

class DefaultController extends Controller
{
    public function menuAction(){
        $xml = new XML();
        $data = $xml->decrypt_routing_file("../app/config/routing.xml");
        return $this->render('SSSAccueilBundle:Default:menu.html.twig', array('routes'=>$data));
    }
    public function indexAction()
    {
        return $this->render('SSSAccueilBundle:Default:index.html.twig');
    }
}
