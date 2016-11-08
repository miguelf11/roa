<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vocablo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Vocablo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Vocabulario")
     * @ORM\JoinColumn(name="vocabulario_id", referencedColumnName="id")
     * @return integer
     */
    private $vocabulario;



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
     * @return Vocablo
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

    /**
     * Set vocabulario
     *
     * @param \ROA\ROABundle\Entity\Vocabulario $vocabulario
     * @return Vocablo
     */
    public function setVocabulario(\ROA\ROABundle\Entity\Vocabulario $vocabulario = null)
    {
        $this->vocabulario = $vocabulario;
    
        return $this;
    }

    /**
     * Get vocabulario
     *
     * @return \ROA\ROABundle\Entity\Vocabulario 
     */
    public function getVocabulario()
    {
        return $this->vocabulario;
    }
}