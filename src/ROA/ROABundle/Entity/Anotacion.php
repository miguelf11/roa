<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ROA\ROABundle\Entity\Anotacion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\AnotacionRepository")
 */
class Anotacion
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
     * @var \DateTime $fecha
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

     /**
     * @ORM\ManyToOne(targetEntity="OA", inversedBy="anotaciones")
     * @ORM\JoinColumn(name="oa_id", referencedColumnName="id")
     * @return integer
     */
    private $oa;

     /**
     * @ORM\ManyToMany(targetEntity="Entidad", inversedBy="anotaciones", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="anotaciones_entidades")
     */
    protected $entidades;

    public function __construct(){

        $this->entidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getEntidades()
    {
        return $this->entidades;
    }

    //public function setEntidades(ArrayCollection $entidades)
    //public function setEntidades($entidades)
    //{
        /*foreach ($entidades as $entidad) {
            $entidad->setAnotacion($this);
        }*/
            //$this->entidades = $entidades;
    //}


    public function addEntidad(Entidad $entidad)
    {
        $entidad->addAnotacion($this); // synchronously updating inverse side
        $this->entidades[] = $entidad;
    }

    public function removeEntidad(Entidad $entidad)
    {
        
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Anotacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Anotacion
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


    public function setOa(\ROA\ROABundle\Entity\OA $oa)
    {
        $this->oa = $oa;
    }

    public function getOa()
    {
        return $this->oa;
    }
}
