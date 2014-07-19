<?php

namespace SSS\AuditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FctAudit
 */
class FctAudit
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $idOui;

    /**
     * @var array
     */
    private $idNon;

    /**
     * @var array
     */
    private $idPartiel;

    private $note;

    public function getNote(){
        return $this->note;
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
     * Set idOui
     *
     * @param array $idOui
     * @return FctAudit
     */
    public function setIdOui($idOui)
    {
        $this->idOui = $idOui;

        return $this;
    }

    /**
     * Get idOui
     *
     * @return array
     */
    public function getIdOui()
    {
        return $this->idOui;
    }

    /**
     * Set idNon
     *
     * @param array $idNon
     * @return FctAudit
     */
    public function setIdNon($idNon)
    {
        $this->idNon = $idNon;

        return $this;
    }

    /**
     * Get idNon
     *
     * @return array
     */
    public function getIdNon()
    {
        return $this->idNon;
    }

    /**
     * Set idPartiel
     *
     * @param array $idPartiel
     * @return FctAudit
     */
    public function setIdPartiel($idPartiel)
    {
        $this->idPartiel = $idPartiel;

        return $this;
    }

    /**
     * Get idPartiel
     *
     * @return array
     */
    public function getIdPartiel()
    {
        return $this->idPartiel;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }
    public function generateNote(){
        $nbrOui = count($this->idOui);
        $nbrPartiel = count($this->idPartiel);

        $this->note = $nbrOui + ($nbrPartiel * 0.5);
        return $this;

    //throw new Exception('Pour calculer une note, les réponses doivent être rensignées');
    }
}
