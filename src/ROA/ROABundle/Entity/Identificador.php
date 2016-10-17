<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Identificador
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Entity\IdentificadorRepository")
 */
class Identificador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="catalogo", type="string", length=255, nullable=true)
     */
    private $catalogo;

    /**
     * @var string
     *
     * @ORM\Column(name="entrada", type="string", length=255, nullable=true)
     */
    private $entrada;


    /**
     * @ORM\ManyToOne(targetEntity="General", inversedBy="identificadores")
     * @ORM\JoinColumn(name="general_id", referencedColumnName="id")
     * @return integer
     */
    private $general;

    /**
     * @ORM\ManyToOne(targetEntity="Recurso", inversedBy="identificadores")
     * @ORM\JoinColumn(name="recurso_id", referencedColumnName="id")
     * @return integer
     */
    private $recurso;

    public function __construct(){

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
     * Set catalogo
     *
     * @param string $catalogo
     * @return Identificador
     */
    public function setCatalogo($catalogo)
    {
        $this->catalogo = $catalogo;
    
        return $this;
    }

    /**
     * Get catalogo
     *
     * @return string 
     */
    public function getCatalogo()
    {
        return $this->catalogo;
    }

    /**
     * Set entrada
     *
     * @param string $entrada
     * @return Identificador
     */
    public function setEntrada($entrada)
    {
        $this->entrada = $entrada;
    
        return $this;
    }

    /**
     * Get entrada
     *
     * @return string 
     */
    public function getEntrada()
    {
        return $this->entrada;
    }

    public function setGeneral(\ROA\ROABundle\Entity\General $general)
    {
        $this->general = $general;
    }

    public function getGeneral()
    {
        return $this->general;
    }

    public function setRecurso(\ROA\ROABundle\Entity\Recurso $recurso)
    {
        $this->recurso = $recurso;
    }

    public function getRecurso()
    {
        return $this->recurso;
    }
}
