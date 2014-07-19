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
        var_dump($id);
        var_dump($audit);
        $this->audits[$id]->setIdOui($audit['id_oui'])
                      ->setIdPartiel($audit['id_partiel'])
                      ->setIdNon($audit['id_non']);

    }
    public function getAudits($parameters, $auditeur, $id){
        if($id != 0){
            $this->audits = array($this->_em->getRepository('SSSAuditBundle:Audit')->find($id));
        }else{
            $this->audits = array(new Audit());
        }
        $this->audits[0]->setClient($parameters['general']['client'])
                  ->setCommentaire($parameters['general']['commentaire'])
                  ->setAuditeur($auditeur);
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

}
