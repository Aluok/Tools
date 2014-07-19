<?php

namespace SSS\AuditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    public function indexAction()
    {
        $audit = array();
        $client = $this->get('security.context')->getToken()->getUser()->getUsername();
       $em = $this->getDoctrine()->getManager();
        $audit['general'] = $em->getRepository('SSSAuditBundle:Audit')->findOneByClient($client);
        $audit['note'] = 0;
        if($audit['general']->testErgo()){
            $audit['ergo'] = $em->getRepository('SSSAuditBundle:ErgoAudit')->find($audit['general']->getId())->generateNote();
            $idNon['ergo'] = $em->getRepository('SSSAuditBundle:Questions')->findNonQuestion($audit['ergo']->getIdNon());
            $audit['note'] += $audit['ergo']->getNote();
        }
        if($audit['general']->testAccess()){
            $audit['access'] = $em->getRepository('SSSAuditBundle:AccessAudit')->find($audit['general']->getId())->generateNote();
            $idNon['access'] = $em->getRepository('SSSAuditBundle:Questions')->findNonQuestion($audit['access']->getIdNon());
            $audit['note'] += $audit['access']->getNote();
        }
        if($audit['general']->testCompa()){
            $audit['compa'] = $em->getRepository('SSSAuditBundle:CompaAudit')->find($audit['general']->getId())->generateNote();
            $idNon['compa'] = $em->getRepository('SSSAuditBundle:Questions')->findNonQuestion($audit['compa']->getIdNon());
            $audit['note'] += $audit['compa']->getNote();
        }
        if($audit['general']->testFct()){
            $audit['fct'] = $em->getRepository('SSSAuditBundle:FctAudit')->find($audit['general']->getId())->generateNote();
            $idNon['fct'] = $em->getRepository('SSSAuditBundle:Questions')->findNonQuestion($audit['fct']->getIdNon());
            $audit['note'] += $audit['fct']->getNote();
        }
        //var_dump($idNon);
        return $this->render('SSSAuditBundle:Client:index.html.twig', array('audit'=> $audit,'idNon'=>$idNon));
    }
}
