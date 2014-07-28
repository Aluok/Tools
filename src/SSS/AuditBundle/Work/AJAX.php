<?php
//exemple sur compa.

namespace SSS\AuditBundle\Work;

use SSS\AuditBundle\Entity\Audit;
use SSS\AuditBundle\Entity\ErgoAudit;
use SSS\AuditBundle\Entity\AccessAudit;
use SSS\AuditBundle\Entity\CompaAudit;
use SSS\AuditBundle\Entity\FctAudit;

class AJAX{
    private $ergo;
    private $compa;
    private $access;
    private $fct;
    private $audits;

    private $_em;

    public function __construct($em){
        $this->ergo = $this->compa = $this->access = $this->fct = false;

        $this->_em = $em;
    }
    public function saveAudit($audit, $id){
        /*var_dump($id);
        var_dump($this->audits);*/
        $this->audits[$id]->setIdOui($audit['id_oui'])
                      ->setIdPartiel($audit['id_partiel'])
                      ->setIdNon($audit['id_non']);

    }
    public function getAudits($parameters, $auditeur, $id = 0){
        //var_dump($parameters);
        $this->initiateGeneral($parameters['general'], $auditeur, $id);
       if($id != 0){
            if($this->audits[0]->testErgo() || isset($parameters['ergo'])){
                $ergo = $this->_em->getRepository('SSSAuditBundle:ErgoAudit')->find($id);
                if($ergo == null){
                    $ergo = new ErgoAudit();
                }else{
                    $this->ergo = true;
                }
                array_push($this->audits, $ergo);
                if(isset($parameters['ergo'])){
                    $this->saveAudit($parameters['ergo'], $this->calculateIndex());
                }
            }
            if($this->audits[0]->testAccess() || isset($parameters['access'])){
                $access = $this->_em->getRepository('SSSAuditBundle:AccessAudit')->find($id);
                if($access == null){
                    $access = new AccessAudit();
                }else{
                    $this->access = true;
                }
                array_push($this->audits, $access);
                if(isset($parameters['access'])){
                    $this->saveAudit($parameters['access'], $this->calculateIndex());
                }
            }
            if($this->audits[0]->testCompa() || isset($parameters['compa'])){
                $compa = $this->_em->getRepository('SSSAuditBundle:CompaAudit')->find($id);
                if($compa == null){
                    $compa = new CompaAudit();
                }else{
                    $this->compa = true;
                }
                array_push($this->audits, $compa);
                if(isset($parameters['compa'])){
                    $this->saveAudit($parameters['compa'], $this->calculateIndex());
                }
            }
            if($this->audits[0]->testFct() || isset($parameters['fct'])){
                $fct = $this->_em->getRepository('SSSAuditBundle:FctAudit')->find($id);
                if($fct == null){
                    $fct = new FctAudit();
                }else{
                    $this->fct = true;
                }
                array_push($this->audits, $fct);
                if(isset($parameters['fct'])){
                    $this->saveAudit($parameters['fct'], $this->calculateIndex());
                }
            }
        }else{
           if(isset($parameters['ergo'])){
               array_push($this->audits, new ErgoAudit());
                $this->ergo = true;
               $this->saveAudit($parameters['ergo'], $this->calculateIndex());

           }
           if(isset($parameters['access'])){
               array_push($this->audits, new AccessAudit());
               $this->access = true;
               $this->saveAudit($parameters['access'], $this->calculateIndex());

           }
           if(isset($parameters['compa'])){
               array_push($this->audits, new CompaAudit());
               $this->compa = true;
               $this->saveAudit($parameters['compa'], $this->calculateIndex());

           }
           if(isset($parameters['fct'])){
                array_push($this->audits, new FctAudit());
                $this->fct = true;
                $this->saveAudit($parameters['fct'], $this->calculateIndex());
           }
       }
        $this->audits[0]->generateAuditNumber($this->ergo, $this->access, $this->compa, $this->fct);

        return $this->audits;
    }
    public function calculateIndex(){
        if($this->ergo && $this->compa && $this->access && $this->fct){
            return 4;
        }
        if(($this->ergo && $this->compa && $this->access) ||
           ($this->ergo && $this->compa && $this->fct) ||
            ($this->ergo && $this->access && $this->fct) ||
            ($this->compa && $this->access && $this->fct)
          )
            return 3;
        else if(($this->ergo && $this->compa) ||
                ($this->ergo && $this->access) ||
                ($this->ergo && $this->fct) ||
                ($this->compa && $this->access) ||
                ($this->compa && $this->fct) ||
                ($this->access && $this->fct)
               )
            return 2;
        else if($this->ergo || $this->compa || $this->access || $this->fct)
            return 1;

    }
    public function initiateGeneral($parametres,$auditeur, $id){
        if($id != 0){
            $this->audits = array($this->_em->getRepository('SSSAuditBundle:Audit')->find($id));
        }else{
            $this->audits = array(new Audit());
        }
        $this->audits[0]->setClient($parametres['client'])
                  ->setCommentaire($parametres['commentaire'])
                  ->setAuditeur($auditeur);
        return $this->audits[0];
    }

    public function setErgo($exist){
        $this->ergo = $exist;
        return $this;
    }
    public function setAccess($exist){
        $this->access = $exist;
        return $this;
    }
    public function setCompa($exist){
        $this->compa = $exist;
        return $this;
    }
    public function setFct($exist){
        $this->fct = $exist;
        return $this;
    }
    public function getErgo(){
        return $this->ergo;
    }
    public function getAccess(){
        return $this->access;
    }
    public function getCompa(){
        return $this->compa;
    }
    public function getFct(){
        return $this->ergo;
    }

}
