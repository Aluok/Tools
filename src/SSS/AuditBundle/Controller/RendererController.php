<?php

namespace SSS\AuditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

use SSS\AuditBundle\Entity\Audit;
use SSS\AuditBundle\Entity\ErgoAudit;
use SSS\AuditBundle\Entity\AccessAudit;
use SSS\AuditBundle\Entity\FctAudit;
use SSS\AuditBundle\Entity\CompaAudit;


class RendererController extends Controller
{
    private function getCategories($type_audit){
        $categories = $this->getDoctrine()->getManager()
            ->getRepository('SSSAuditBundle:Questions')
            ->findAllCategories($type_audit);
        $length = count($categories);
        for($i = 0; $i < $length; $i++){
            $categories[$i]['questions'] = $this->getDoctrine()->getManager()
                ->getRepository('SSSAuditBundle:Questions')
                ->findQuestionsByCategorieAndTypeAudit($categories[$i]['categorie'], $type_audit);
        }
        return $categories;
    }

    public function FctAction($existant){
        if($existant == null){
            $existant = array();
            $existant['fct'] = new FctAudit();
        }
        $general = array('id'=>'fonctionnalites', 'nom'=>'Fonctionnalités');
        $categories = $this->getCategories(Audit::FCT);
        return $this->render('SSSAuditBundle:Renderer:base.html.twig', array("general" => $general,
                                                                            "categories"=> $categories,
                                                                            "existant" => $existant['fct']));
    }
    public function CompaAction($existant){
        if($existant['compa'] == null){
            $existant = array();
            $existant['compa'] = new CompaAudit();
        }
        $general = array('id'=>'compatibilite', 'nom'=>'Compatibilité');
        $categories = $this->getCategories(Audit::COMPA);
        return $this->render('SSSAuditBundle:Renderer:base.html.twig', array("general" => $general,
                                                                            "categories"=> $categories,
                                                                            "existant" => $existant['compa']));
    }
    public function ErgoAction($existant){
        if($existant == null){
            $existant = array();
            $existant['ergo'] = new ErgoAudit();
        }
        $general = array('id'=>'ergonomie', 'nom'=>'Ergonomie');
        $categories = $this->getCategories(Audit::ERGO);
        return $this->render('SSSAuditBundle:Renderer:base.html.twig', array("general" => $general,
                                                                            "categories"=> $categories,
                                                                            "existant" => $existant['ergo']));
    }
    public function AccessAction($existant){
        if($existant == null){
            $existant = array();
            $existant['access'] = new AccessAudit();
        }
        $general = array('id'=>'accessibilite', 'nom'=>'Accessibilité');
        $categories = $this->getCategories(Audit::ACCESS);
        return $this->render('SSSAuditBundle:Renderer:base.html.twig', array("general" => $general,
                                                                            "categories"=> $categories,
                                                                            "existant" => $existant['access']));
    }
}
