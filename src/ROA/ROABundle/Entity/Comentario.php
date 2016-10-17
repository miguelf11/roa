<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\ComentarioRepository")
 */
class Comentario
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
     *
     * @ORM\Column(name="fecha_publicacion", type="datetime", nullable=true)
     */
    private $fecha_publicacion;


    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_status_comentario", referencedColumnName="id")
     * @return integer
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="OA", inversedBy="comentarios")
     * @ORM\JoinColumn(name="oa_id", referencedColumnName="id")
     * @return integer
     */
    private $oa;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="comentarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @return integer
     */
    private $usuario;


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
     * @return Comentario
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

    public function setFecha_publicacion($fecha_publicacion)
    {
        $this->fecha_publicacion = $fecha_publicacion;
    
        return $this;
    }

    public function getFecha_publicacion()
    {
        return $this->fecha_publicacion;
    }

    public function setOa(\ROA\ROABundle\Entity\OA $oa)
    {
        $this->oa = $oa;
    }

    public function getOa()
    {
        return $this->oa;
    }

    public function setUsuario(\ROA\ROABundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

}
