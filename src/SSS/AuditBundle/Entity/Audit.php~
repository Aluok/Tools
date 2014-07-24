<?php

namespace SSS\AuditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Audit
 */
class Audit
{
    /**
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @JMS\Type("integer")
     */
    private $auditeur;

    /**
     * @JMS\Type("integer")
     */
    private $audits;

    /**
     * @JMS\Type("string")
     */
    private $client;

    /**
     * @JMS\Type("string")
     */
    private $commentaire;

    const ERGO =    1;
    const ACCESS =  2;
    const COMPA =   4;
    const FCT =     8;

    public function __invoke($type){
        if($type == 'ergo'){
            return $this->testErgo();
        }else if($type == 'access'){
            return $this->testAccess();
        }else if($type == 'compa'){
            return $this->testCompa();
        }else if($type == 'fct'){
            return $this->testFct();
        }
    }
    public function arrayAudit(){
        return array('ergo', 'access', 'compa', 'fct');
    }
    public function __construct(){
        $this->audit = 0;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set auditeur
     *
     * @param integer $auditeur
     * @return Audit
     */
    public function setAuditeur($auditeur)
    {
        $this->auditeur = $auditeur;

        return $this;
    }

    /**
     * Get auditeur
     *
     * @return integer
     */
    public function getAuditeur()
    {
        return $this->auditeur;
    }

    /**
     * Set audits
     *
     * @param integer $audits
     * @return Audit
     */
    public function setAudits($audits) {
        $this->audits = $audits;

        return $this;
    }

    /**
     * Get audits
     *
     * @return integer
     */
    public function getAudits() {
        return $this->audits;
    }

    /**
     * Set client
     *
     * @param string $client
     * @return Audit
     */
    public function setClient($client) {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient() {
        return $this->client;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Audit
     */
    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire() {
        return $this->commentaire;
    }
    public function generateAuditNumber($ergo, $access, $compa, $fct){
        $this->audits = 0;
        if($ergo){
            $this->audits += self::ERGO;
        }
        if($fct){
            $this->audits += self::FCT;
        }
        if($compa){
            $this->audits += self::COMPA;
        }
        if($access){
            $this->audits += self::ACCESS;
        }
    }
    public function testErgo(){
        return $this->audits == Audit::ERGO ||
               $this->audits == Audit::ERGO + Audit::ACCESS ||
               $this->audits == Audit::ERGO + Audit::COMPA ||
               $this->audits == Audit::ERGO + Audit::FCT ||
               $this->audits == Audit::ERGO + Audit::ACCESS + Audit::COMPA||
               $this->audits == Audit::ERGO + Audit::ACCESS + Audit::FCT||
               $this->audits == Audit::ERGO + Audit::FCT + Audit::COMPA||
               $this->audits == Audit::ERGO + Audit::FCT + Audit::COMPA + Audit::ACCESS;
    }
    public function testAccess(){
        return $this->audits == Audit::ACCESS ||
               $this->audits == Audit::ACCESS + Audit::ERGO ||
               $this->audits == Audit::ACCESS + Audit::COMPA ||
               $this->audits == Audit::ACCESS + Audit::FCT ||
               $this->audits == Audit::ACCESS + Audit::ERGO + Audit::COMPA||
               $this->audits == Audit::ACCESS + Audit::ERGO + Audit::FCT||
               $this->audits == Audit::ACCESS + Audit::FCT + Audit::COMPA||
               $this->audits == Audit::ACCESS + Audit::FCT + Audit::COMPA + Audit::ERGO;
    }
    public function testCompa(){
        return $this->audits == Audit::COMPA ||
               $this->audits == Audit::COMPA + Audit::ERGO ||
               $this->audits == Audit::COMPA + Audit::ACCESS ||
               $this->audits == Audit::COMPA + Audit::FCT ||
               $this->audits == Audit::COMPA + Audit::ERGO + Audit::ACCESS||
               $this->audits == Audit::COMPA + Audit::ERGO + Audit::FCT||
               $this->audits == Audit::COMPA + Audit::FCT + Audit::ACCESS||
               $this->audits == Audit::COMPA + Audit::FCT + Audit::ACCESS + Audit::ERGO;
    }
    public function testFct(){
        return $this->audits == Audit::FCT ||
               $this->audits == Audit::FCT + Audit::ERGO ||
               $this->audits == Audit::FCT + Audit::COMPA ||
               $this->audits == Audit::FCT + Audit::ACCESS ||
               $this->audits == Audit::FCT + Audit::ERGO + Audit::COMPA||
               $this->audits == Audit::FCT + Audit::ERGO + Audit::ACCESS||
               $this->audits == Audit::FCT + Audit::ACCESS + Audit::COMPA||
               $this->audits == Audit::FCT + Audit::ACCESS + Audit::COMPA + Audit::ERGO;
    }
}
