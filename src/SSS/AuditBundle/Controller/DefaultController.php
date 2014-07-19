<?php

namespace SSS\AuditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SSSAuditBundle:Default:index.html.twig');
    }
}
