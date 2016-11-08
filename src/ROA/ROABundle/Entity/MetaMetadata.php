<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ROA\ROABundle\Entity\MetaMetadata
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\MetaMetadataRepository")
 */
class MetaMetadata
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
     * @var string $lenguaje
     *
     * @ORM\Column(name="lenguaje", type="string", length=30, nullable=true)
     */
    private $lenguaje;

    /**
     * @var string $esquema
     *
     * @ORM\Column(name="esquema", type="string", length=25, nullable=true)
     * @Assert\NotBlank(message="Campo Requerido", groups={"create", "update"})
     */
    private $esquema;

    /**
     * @ORM\OneToMany(targetEntity="Contribucion", mappedBy="metametadata", cascade={"persist","remove"})
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
     * Set lenguaje
     *
     * @param string $lenguaje
     * @return MetaMetadata
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
     * Set esquema
     *
     * @param string $esquema
     * @return MetaMetadata
     */
    public function setEsquema($esquema)
    {
        $this->esquema = $esquema;
    
        return $this;
    }

    /**
     * Get esquema
     *
     * @return string 
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    public function __construct()
    {
        $this->contribuciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /*public function addContribucion(\ROA\ROABundle\Entity\Contribucion $contribucion)
    {
        $this->contribucion[] = $contribucion;
    }*/

    public function getContribuciones()
    {
        //return $this->contribucion->toArray();
        return $this->contribuciones;
    }
    //public function setContribuciones(ArrayCollection $contribuciones)
    public function setContribuciones($contribuciones)
    {
        foreach ($contribuciones as $contribucion) {
            $contribucion->setMetaMetadata($this);
        }
            $this->contribuciones = $contribuciones;
    }

    /**
     * Add contribuciones
     *
     * @param \ROA\ROABundle\Entity\Contribucion $contribuciones
     * @return MetaMetadata
     */
    public function addContribucione(\ROA\ROABundle\Entity\Contribucion $contribuciones)
    {
        $this->contribuciones[] = $contribuciones;
    
        return $this;
    }

    /**
     * Remove contribuciones
     *
     * @param \ROA\ROABundle\Entity\Contribucion $contribuciones
     */
    public function removeContribucione(\ROA\ROABundle\Entity\Contribucion $contribuciones)
    {
        $this->contribuciones->removeElement($contribuciones);
    }
}