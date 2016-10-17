<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recurso
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Recurso
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
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;


    /**
     * @ORM\OneToMany(targetEntity="Identificador", mappedBy="recurso", cascade={"persist","remove"})
     */
    protected $identificadores;

    public function __construct(){

        $this->identificadores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Recurso
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getIdentificadores()
    {
        return $this->identificadores;
    }
    public function setIdentificadores($identificadores)
    {
        foreach ($identificadores as $identificador) {
            $identificador->setRecurso($this);
        }
            $this->identificadores = $identificadores;
    }
}
