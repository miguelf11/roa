<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ROA\ROABundle\Entity\Clasificacion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\ClasificacionRepository")
 */
class Clasificacion
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
     * @ORM\JoinColumn(name="vocablo_id_proposito", referencedColumnName="id")
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     * @return integer
     */
    private $proposito;


    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string $clave
     *
     * @ORM\Column(name="clave", type="string", length=100, nullable=true)
     */
    private $clave;

    /**
     * @ORM\ManyToOne(targetEntity="OA", inversedBy="clasificaciones")
     * @ORM\JoinColumn(name="oa_id", referencedColumnName="id")
     * @return integer
     */
    private $oa;


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
     * Set proposito
     *
     * @param string $proposito
     * @return Clasificacion
     */
    public function setProposito($proposito)
    {
        $this->proposito = $proposito;
    
        return $this;
    }

    /**
     * Get proposito
     *
     * @return string 
     */
    public function getProposito()
    {
        return $this->proposito;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Clasificacion
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
     * Set clave
     *
     * @param string $clave
     * @return Clasificacion
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    
        return $this;
    }

    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    public function setOa(\ROA\ROABundle\Entity\OA $oa)
    {
        $this->oa = $oa;
    }

    public function getOa()
    {
        return $this->oa;
    }
}
