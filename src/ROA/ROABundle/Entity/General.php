<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ROA\ROABundle\Entity\General
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\GeneralRepository")
 */
class General
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
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     */
    private $lenguaje;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     */
    private $descripcion;

    /**
     * @var string $clave
     *
     * @ORM\Column(name="clave", type="string", length=30, nullable=true)
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     */
    private $clave;

    /**
     * @var string $cobertura
     *
     * @ORM\Column(name="cobertura", type="string", length=100, nullable=true)
     */
    private $cobertura;

    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_estructura", referencedColumnName="id")
     * @return integer
     */
    private $estructura;

    /**
     * @var string $nivel_agregacion
     *
     * @ORM\Column(name="nivel_agregacion", type="string", length=25, nullable=true)
     */
    private $nivel_agregacion;


    /**
     * @ORM\OneToMany(targetEntity="Identificador", mappedBy="general", cascade={"persist","remove"})
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
     * Set lenguaje
     *
     * @param string $lenguaje
     * @return General
     */
    public function setLenguaje($lenguaje)
    {
        $this->lenguaje = $lenguaje;
    
        return $this;
    }

    /**
     * Get lenguaje
     *
     * @return string 
     */
    public function getLenguaje()
    {
        return $this->lenguaje;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return General
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
     * @return General
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

    /**
     * Set cobertura
     *
     * @param string $cobertura
     * @return General
     */
    public function setCobertura($cobertura)
    {
        $this->cobertura = $cobertura;
    
        return $this;
    }

    /**
     * Get cobertura
     *
     * @return string 
     */
    public function getCobertura()
    {
        return $this->cobertura;
    }

    /**
     * Set estructura
     *
     * @param string $estructura
     * @return General
     */
    public function setEstructura($estructura)
    {
        $this->estructura = $estructura;
    
        return $this;
    }

    /**
     * Get estructura
     *
     * @return string 
     */
    public function getEstructura()
    {
        return $this->estructura;
    }

    /**
     * Set nivel_agregacion
     *
     * @param string $nivelAgregacion
     * @return General
     */
    public function setNivelAgregacion($nivelAgregacion)
    {
        $this->nivel_agregacion = $nivelAgregacion;
    
        return $this;
    }

    /**
     * Get nivel_agregacion
     *
     * @return string 
     */
    public function getNivelAgregacion()
    {
        return $this->nivel_agregacion;
    }

    public function getIdentificadores()
    {
        return $this->identificadores;
    }
    public function setIdentificadores($identificadores)
    {
        foreach ($identificadores as $identificador) {
            $identificador->setGeneral($this);
        }
            $this->identificadores = $identificadores;
    }
    
}
