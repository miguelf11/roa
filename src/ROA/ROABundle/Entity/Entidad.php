<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entidad
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Entidad
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
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="organizacion", type="string", length=100, nullable=true)
     */
    private $organizacion;


    /**
     * @ORM\ManyToMany(targetEntity="Contribucion", mappedBy="entidades", cascade={"persist"})
     */
    private $contribuciones;


    /**
     * @ORM\ManyToMany(targetEntity="Anotacion", mappedBy="entidades", cascade={"persist"})
     */
    private $anotaciones;

    public function __construct(){

        $this->anotaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contribuciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function getAnotaciones()
    {
        return $this->anotaciones;
    }

    //public function setEntidades(ArrayCollection $entidades)
    //public function setAnotaciones($anotaciones)
    //{
        /*foreach ($entidades as $entidad) {
            $entidad->setAnotacion($this);
        }*/
            //$this->anotaciones = $anotaciones;
    //}

    public function addAnotacion(Anotacion $anotacion)
    {
        $this->anotaciones[] = $anotacion;
    }

    public function addContribucion(Contribucion $contribucion)
    {
        $this->contribuciones[] = $contribucion;
    }
    public function getContribuciones()
    {
        return $this->contribuciones;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Entidad
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Entidad
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set organizacion
     *
     * @param string $organizacion
     * @return Entidad
     */
    public function setOrganizacion($organizacion)
    {
        $this->organizacion = $organizacion;
    
        return $this;
    }

    /**
     * Get organizacion
     *
     * @return string 
     */
    public function getOrganizacion()
    {
        return $this->organizacion;
    }

    /*public function setContribucion(\ROA\ROABundle\Entity\Contribucion $contribucion)
    {
        $this->contribucion = $contribucion;
    }

    public function getContribucion()
    {
        return $this->contribucion;
    }*/
    /*public function setAnotacion(\ROA\ROABundle\Entity\Anotacion $anotacion)
    {
        $this->anotacion = $anotacion;
    }

    public function getAnotacion()
    {
        return $this->anotacion;
    }*/
}
