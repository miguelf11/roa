<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ROA\ROABundle\Entity\Contribucion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\ContribucionRepository")
 */
class Contribucion
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
     * @var string $rol
     *
     * @ORM\Column(name="rol", type="string", length=60, nullable=true)
     */
    private $rol;

    /**
     * @var \DateTime $fecha
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="CicloVida", inversedBy="contribuciones")
     * @ORM\JoinColumn(name="ciclovida_id", referencedColumnName="id")
     * @return integer
     */
    private $ciclovida;

    /**
     * @ORM\ManyToOne(targetEntity="MetaMetadata", inversedBy="contribuciones")
     * @ORM\JoinColumn(name="metametadata_id", referencedColumnName="id")
     * @return integer
     */
    private $metametadata;

    /**
     * @ORM\ManyToMany(targetEntity="Entidad", inversedBy="contribuciones", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="contribuciones_entidades")
     */
    protected $entidades;


    public function __construct(){

        $this->entidades = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function getEntidades()
    {
        return $this->entidades;
    }
    public function addEntidad(Entidad $entidad)
    {
        $entidad->addContribucion($this); // synchronously updating inverse side
        $this->entidades[] = $entidad;
    }
    public function removeEntidad(Entidad $entidad)
    {
        
    }

    //public function setEntidades(ArrayCollection $entidades)
    /*public function setEntidades($entidades)
    {
       // $this->tags = $tags;
        foreach ($entidades as $entidad) {
            $entidad->setContribucion($this);
        }
            $this->entidades = $entidades;
    }*/


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
     * Set rol
     *
     * @param string $rol
     * @return Contribucion
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    
        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Contribucion
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

    public function setCiclovida(\ROA\ROABundle\Entity\CicloVida $ciclovida)
    {
        $this->ciclovida = $ciclovida;
    }

    public function getCiclovida()
    {
        return $this->ciclovida;
    }

    public function setMetametadata(\ROA\ROABundle\Entity\MetaMetadata $metametadata)
    {
        $this->metametadata = $metametadata;
    }

    public function getMetametadata()
    {
        return $this->metametadata;
    }

    /**
     * Add entidades
     *
     * @param \ROA\ROABundle\Entity\Entidad $entidades
     * @return Contribucion
     */
    public function addEntidade(\ROA\ROABundle\Entity\Entidad $entidades)
    {
        $this->entidades[] = $entidades;
    
        return $this;
    }

    /**
     * Remove entidades
     *
     * @param \ROA\ROABundle\Entity\Entidad $entidades
     */
    public function removeEntidade(\ROA\ROABundle\Entity\Entidad $entidades)
    {
        $this->entidades->removeElement($entidades);
    }
}