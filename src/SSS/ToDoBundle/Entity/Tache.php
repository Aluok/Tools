<?php

namespace SSS\ToDoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache DTO
 */
class Tache
{

    public $id;
    public $titre;
    public $description;
    public $sousTaches;
    public $tachePrincipale;

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
     * Set titre
     *
     * @param string $titre
     * @return Tache
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Tache
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sousTaches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sousTaches
     *
     * @param \SSS\ToDoBundle\Entity\Tache $sousTaches
     * @return Tache
     */
    public function addSousTach(\SSS\ToDoBundle\Entity\Tache $sousTaches)
    {
        $this->sousTaches[] = $sousTaches;

        return $this;
    }

    /**
     * Remove sousTaches
     *
     * @param \SSS\ToDoBundle\Entity\Tache $sousTaches
     */
    public function removeSousTach(\SSS\ToDoBundle\Entity\Tache $sousTaches)
    {
        $this->sousTaches->removeElement($sousTaches);
    }

    /**
     * Get sousTaches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSousTaches()
    {
        return $this->sousTaches;
    }

    /**
     * Set tachePrincipale
     *
     * @param \SSS\ToDoBundle\Entity\Tache $tachePrincipale
     * @return Tache
     */
    public function setTachePrincipale(\SSS\ToDoBundle\Entity\Tache $tachePrincipale = null)
    {
        $this->tachePrincipale = $tachePrincipale;

        return $this;
    }

    /**
     * Get tachePrincipale
     *
     * @return \SSS\ToDoBundle\Entity\Tache
     */
    public function getTachePrincipale()
    {
        return $this->tachePrincipale;
    }
}
