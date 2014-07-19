<?php

namespace SSS\AuditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 */
class Questions
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $question;

    /**
     * @var string
     */
    private $categorie;

    /**
     * @var integer
     */
    private $typeAudit;

    private $require;

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
     * Set question
     *
     * @param string $question
     * @return Questions
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     * @return Questions
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set typeAudit
     *
     * @param integer $typeAudit
     * @return Questions
     */
    public function setTypeAudit($typeAudit)
    {
        $this->typeAudit = $typeAudit;

        return $this;
    }

    /**
     * Get typeAudit
     *
     * @return integer
     */
    public function getTypeAudit()
    {
        return $this->typeAudit;
    }

    /**
     * Set require
     *
     * @param \SSS\AuditBundle\Entity\Questions $require
     * @return Questions
     */
    public function setRequire(\SSS\AuditBundle\Entity\Questions $require = null)
    {
        $this->require = $require;

        return $this;
    }

    /**
     * Get require
     *
     * @return \SSS\AuditBundle\Entity\Questions
     */
    public function getRequire()
    {
        return $this->require;
    }
}
