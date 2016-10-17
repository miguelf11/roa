<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ROA\ROABundle\Entity\Educacional
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\EducacionalRepository")
 */
class  Educacional
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
     * @ORM\JoinColumn(name="vocablo_id_tipo_interaccion", referencedColumnName="id")
     * @return integer
     */
    private $tipo_interaccion;

    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_tipo_recurso", referencedColumnName="id")
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     * @return integer
     */
    private $tipo_recurso;

    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_nivel_interaccion", referencedColumnName="id")
     * @return integer
     */
    private $nivel_interaccion;

    /**
     * @var string $semantica
     *
     * @ORM\Column(name="semantica", type="string", length=25, nullable=true)
     */
    private $semantica;

    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_rol", referencedColumnName="id")
     * @return integer
     */
    private $rol;

   /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_contexto", referencedColumnName="id")
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     * @return integer
     */
    private $contexto;

    /**
     * @var integer $edad
     *
     * @ORM\Column(name="edad", type="integer", length=3, nullable=true)
     */
    private $edad;

    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_dificultad", referencedColumnName="id")
     * @return integer
     */
    private $dificultad;

    /**
     * @var string $tiempo
     *
     * @ORM\Column(name="tiempo", type="string", length=20, nullable=true)
     */
    private $tiempo;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string $lenguaje
     *
     * @ORM\Column(name="lenguaje", type="string", length=30, nullable=true)
     */
    private $lenguaje;


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
     * Set tipo_interaccion
     *
     * @param string $tipoInteraccion
     * @return  Educacional
     */
    public function setTipoInteraccion($tipoInteraccion)
    {
        $this->tipo_interaccion = $tipoInteraccion;
    
        return $this;
    }

    /**
     * Get tipo_interaccion
     *
     * @return string 
     */
    public function getTipoInteraccion()
    {
        return $this->tipo_interaccion;
    }

    /**
     * Set tipo_recurso
     *
     * @param string $tipoRecurso
     * @return  Educacional
     */
    public function setTipoRecurso($tipoRecurso)
    {
        $this->tipo_recurso = $tipoRecurso;
    
        return $this;
    }

    /**
     * Get tipo_recurso
     *
     * @return string 
     */
    public function getTipoRecurso()
    {
        return $this->tipo_recurso;
    }

    /**
     * Set nivel_interaccion
     *
     * @param string $nivelInteraccion
     * @return  Educacional
     */
    public function setNivelInteraccion($nivelInteraccion)
    {
        $this->nivel_interaccion = $nivelInteraccion;
    
        return $this;
    }

    /**
     * Get nivel_interaccion
     *
     * @return string 
     */
    public function getNivelInteraccion()
    {
        return $this->nivel_interaccion;
    }

    /**
     * Set semantica
     *
     * @param string $semantica
     * @return  Educacional
     */
    public function setSemantica($semantica)
    {
        $this->semantica = $semantica;
    
        return $this;
    }

    /**
     * Get semantica
     *
     * @return string 
     */
    public function getSemantica()
    {
        return $this->semantica;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * @return  Educacional
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
     * Set contexto
     *
     * @param string $contexto
     * @return  Educacional
     */
    public function setContexto($contexto)
    {
        $this->contexto = $contexto;
    
        return $this;
    }

    /**
     * Get contexto
     *
     * @return string 
     */
    public function getContexto()
    {
        return $this->contexto;
    }

    /**
     * Set edad
     *
     * @param string $edad
     * @return  Educacional
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
    
        return $this;
    }

    /**
     * Get edad
     *
     * @return string 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set dificultad
     *
     * @param string $dificultad
     * @return  Educacional
     */
    public function setDificultad($dificultad)
    {
        $this->dificultad = $dificultad;
    
        return $this;
    }

    /**
     * Get dificultad
     *
     * @return string 
     */
    public function getDificultad()
    {
        return $this->dificultad;
    }

    /**
     * Set tiempo
     *
     * @param string $tiempo
     * @return  Educacional
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;
    
        return $this;
    }

    /**
     * Get tiempo
     *
     * @return string 
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return  Educacional
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
     * Set lenguaje
     *
     * @param string $lenguaje
     * @return  Educacional
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
    public function __construct()
    {
    }
}
