<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Entity\AreaRepository")
 */
class Area
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;


    /**
     * @ORM\OneToMany(targetEntity="OA", mappedBy="area", cascade={"persist", "remove"})
     */
    private $oas;

    /**
     * @ORM\ManyToOne(targetEntity="Subcategoria", inversedBy="areas")
     * @ORM\JoinColumn(name="subcategoria", referencedColumnName="id")
     * @return integer
     */
    private $subcategoria;

    public function __construct(){

        $this->oas = new \Doctrine\Common\Collections\ArrayCollection();

    }

    public function getOas()
    {
        //return $this->oas->toArray();
        return $this->oas;
    }

    public function setOas($oas)
    {
        foreach ($oas as $oa) {
            $oa->setSubategoria($this);
        }
        $this->oas = $oas;
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
     * @return Area
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

     public function setArea(\ROA\ROABundle\Entity\Area $area)
    {
        $this->area = $area;
    }

    public function getArea()
    {
        return $this->area;
    }

    /**
     * Add oas
     *
     * @param \ROA\ROABundle\Entity\OA $oas
     * @return Area
     */
    public function addOa(\ROA\ROABundle\Entity\OA $oas)
    {
        $this->oas[] = $oas;
    
        return $this;
    }

    /**
     * Remove oas
     *
     * @param \ROA\ROABundle\Entity\OA $oas
     */
    public function removeOa(\ROA\ROABundle\Entity\OA $oas)
    {
        $this->oas->removeElement($oas);
    }
}