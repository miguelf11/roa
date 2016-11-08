<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ROA\ROABundle\Entity\Derechos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\DerechosRepository")
 */
class Derechos
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_costo", referencedColumnName="id")
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     * @return integer
     */
    private $costo;

    /**
     * @var string $restricciones
     *
     * @ORM\Column(name="restricciones", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     */
    private $restricciones;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     */
    private $descripcion;


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
     * Set costo
     *
     * @param string $costo
     * @return Derechos
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;
    
        return $this;
    }

    /**
     * Get costo
     *
     * @return string 
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set restricciones
     *
     * @param string $restricciones
     * @return Derechos
     */
    public function setRestricciones($restricciones)
    {
        $this->restricciones = $restricciones;
    
        return $this;
    }

    /**
     * Get restricciones
     *
     * @return string 
     */
    public function getRestricciones()
    {
        return $this->restricciones;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Derechos
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
}