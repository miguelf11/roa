<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ROA\ROABundle\Entity\CicloVida
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\CicloVidaRepository")
 */
class CicloVida
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
     * @var string $version
     *
     * @ORM\Column(name="version", type="string", length=20, nullable=true)
     */
    private $version;

    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_status", referencedColumnName="id")
     * @return integer
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="Contribucion", mappedBy="ciclovida", cascade={"persist","remove"})
     */
    protected $contribuciones;


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
     * Set version
     *
     * @param string $version
     * @return CicloVida
     */
    public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return CicloVida
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function __construct()
    {
        $this->contribuciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function getContribuciones()
    {
        //return $this->contribucion->toArray();
        return $this->contribuciones;
    }
    public function setContribuciones($contribuciones)
    {
        foreach ($contribuciones as $contribucion) {
            $contribucion->setCiclovida($this);
        }
            $this->contribuciones = $contribuciones;
    }
    /*public function addContribucion(\ROA\ROABundle\Entity\Contribucion $contribucion)
    {
        $this->contribucion[] = $contribucion;
    }

    public function getContribucion()
    {
        //return $this->contribucion->toArray();
        return $this->contribucion;
    }*/
}
