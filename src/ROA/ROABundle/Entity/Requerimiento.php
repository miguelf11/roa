<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ROA\ROABundle\Entity\Requerimiento
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\RequerimientoRepository")
 */
class Requerimiento
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
     * @var string $tipo
     *
     * @ORM\Column(name="tipo", type="string", length=60, nullable=true)
     */
    private $tipo;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=60, nullable=true)
     */
    private $nombre;

    /**
     * @var string $version_minima
     *
     * @ORM\Column(name="version_minima", type="string", length=20, nullable=true)
     */
    private $version_minima;

    /**
     * @var string $version_maxima
     *
     * @ORM\Column(name="version_maxima", type="string", length=20, nullable=true)
     */
    private $version_maxima;

    /**
     * @ORM\ManyToOne(targetEntity="Tecnico", inversedBy="requerimientos")
     * @ORM\JoinColumn(name="tecnico_id", referencedColumnName="id")
     * @return integer
     */
    private $tecnico;


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
     * Set tipo
     *
     * @param string $tipo
     * @return Requerimiento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Requerimiento
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
     * Set version_minima
     *
     * @param string $versionMinima
     * @return Requerimiento
     */
    public function setVersionMinima($versionMinima)
    {
        $this->version_minima = $versionMinima;
    
        return $this;
    }

    /**
     * Get version_minima
     *
     * @return string 
     */
    public function getVersionMinima()
    {
        return $this->version_minima;
    }

    /**
     * Set version_maxima
     *
     * @param string $versionMaxima
     * @return Requerimiento
     */
    public function setVersionMaxima($versionMaxima)
    {
        $this->version_maxima = $versionMaxima;
    
        return $this;
    }

    /**
     * Get version_maxima
     *
     * @return string 
     */
    public function getVersionMaxima()
    {
        return $this->version_maxima;
    }

    public function setTecnico(\ROA\ROABundle\Entity\Tecnico $tecnico)
    {
        $this->tecnico = $tecnico;
    }

    public function getTecnico()
    {
        return $this->tecnico;
    }
}