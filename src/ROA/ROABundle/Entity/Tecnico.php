<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ROA\ROABundle\Entity\Tecnico
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\TecnicoRepository")
 */
class Tecnico
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
     * @var string $formato
     *
     * @ORM\Column(name="formato", type="string", length=20, nullable=true)
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     */
    private $formato;

    /**
     * @var integer $tamano
     *
     * @ORM\Column(name="tamano", type="string", nullable=true)
     */
    private $tamano;

    /**
     * @var string $ubicacion
     *
     * @ORM\Column(name="ubicacion", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     */
    private $ubicacion;

    /**
     * @var string $comentario
     *
     * @ORM\Column(name="comentario", type="string", length=255, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\OneToMany(targetEntity="Requerimiento", mappedBy="tecnico", cascade={"persist", "remove"})
     */
    private $requerimientos;


    /**
     * @var string $requisitos
     *
     * @ORM\Column(name="requisitos", type="string", length=255, nullable=true)
     */
    private $requisitos;

    /**
     * @var string $duracion
     *
     * @ORM\Column(name="duracion", type="string", length=20, nullable=true)
     */
    private $duracion;


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
     * Set formato
     *
     * @param string $formato
     * @return Tecnico
     */
    public function setFormato($formato)
    {
        $this->formato = $formato;
    
        return $this;
    }

    /**
     * Get formato
     *
     * @return string 
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Set tamano
     *
     * @param integer $tamano
     * @return Tecnico
     */
    public function setTamano($tamano)
    {
        $this->tamano = $tamano;
    
        return $this;
    }

    /**
     * Get tamano
     *
     * @return integer 
     */
    public function getTamano()
    {
        return $this->tamano;
    }

    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     * @return Tecnico
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    
        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return Tecnico
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    
        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set requisitos
     *
     * @param string $requisitos
     * @return Tecnico
     */
    public function setRequisitos($requisitos)
    {
        $this->requisitos = $requisitos;
    
        return $this;
    }

    /**
     * Get requisitos
     *
     * @return string 
     */
    public function getRequisitos()
    {
        return $this->requisitos;
    }

    /**
     * Set duracion
     *
     * @param string $duracion
     * @return Tecnico
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
    
        return $this;
    }

    /**
     * Get duracion
     *
     * @return string 
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    public function __construct()
    {
        $this->requerimientos = new \Doctrine\Common\Collections\ArrayCollection();
    }
     public function getRequerimientos()
    {
        //return $this->requerimientos->toArray();
        return $this->requerimientos;
    }
    public function setRequerimientos($requerimientos)
    {
        foreach ($requerimientos as $requerimiento) {
            $requerimiento->setTecnico($this);
        }
            $this->requerimientos = $requerimientos;
    }
    /*public function addRequerimiento(\ROA\ROABundle\Entity\Requerimiento $requerimiento)
    {
        $this->requerimiento[] = $requerimiento;
    }

    public function getRequerimiento()
    {
        //return $this->requerimiento->toArray();
        return $this->requerimiento;
    }*/
}
