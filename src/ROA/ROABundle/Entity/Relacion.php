<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ROA\ROABundle\Entity\Relacion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\RelacionRepository")
 */
class Relacion
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
     * @ORM\JoinColumn(name="vocablo_id_tipo_relacion", referencedColumnName="id")
     * @return integer
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="OA", inversedBy="relaciones")
     * @ORM\JoinColumn(name="oa_id", referencedColumnName="id")
     * @return integer
     */
    private $oa;

    /**
     * @ORM\OneToOne(targetEntity="Recurso", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="recurso_id", referencedColumnName="id")
     */
    private $recurso;

    public function __construct()
    {
        $this->recurso = New \ROA\ROABundle\Entity\Recurso();
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
     * Set tipo
     *
     * @param string $tipo
     * @return Relacion
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

    public function setOa(\ROA\ROABundle\Entity\OA $oa)
    {
        $this->oa = $oa;
    }

    public function getOa()
    {
        return $this->oa;
    }
    public function setRecurso(\ROA\ROABundle\Entity\Recurso $recurso)
    {
        $this->recurso = $recurso;
    }

    public function getRecurso()
    {
        return $this->recurso;
    }
}
