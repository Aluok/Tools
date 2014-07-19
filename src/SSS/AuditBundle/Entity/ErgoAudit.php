<?php

namespace SSS\AuditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * ErgoAudit
 */
class ErgoAudit
{
    /**
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @JMS\Type("integer")
     */
    private $note;

    /**
     * @JMS\Type("array")
     */
    private $idOui;

    /**
     * @JMS\Type("array")
     */
    private $idNon;

    /**
     * @JMS\Type("array")
     */
    private $idPartiel;

    const NBR_QUESTIONS = 50;

    public function setId($id){
        $this->id = $id;
        return $this;
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
     * Set note
     *
     * @param integer $note
     * @return ErgoAudit
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set nbrNonPertinent
     *
     * @param integer $nbrNonPertinent
     * @return ErgoAudit
     */
    public function setNbrNonPertinent($nbrNonPertinent)
    {
        $this->nbrNonPertinent = $nbrNonPertinent;

        return $this;
    }

    /**
     * Get nbrNonPertinent
     *
     * @return integer
     */
    public function getNbrNonPertinent()
    {
        return $this->nbrNonPertinent;
    }

    /**
     * Set idNon
     *
     * @param array $idNon
     * @return ErgoAudit
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
     * Set idOui
     *
     * @param array $idOui
     * @return ErgoAudit
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
     * Set idPartiel
     *
     * @param array $idPartiel
     * @return ErgoAudit
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
    public function generateNote(){
        $nbrOui = count($this->idOui);
        $nbrPartiel = count($this->idPartiel);

        $this->note = $nbrOui + ($nbrPartiel * 0.5);
        return $this;

    //throw new Exception('Pour calculer une note, les réponses doivent être rensignées');
    }
}
