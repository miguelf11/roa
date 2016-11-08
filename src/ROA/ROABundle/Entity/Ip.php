<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ip
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\IpRepository")
 */
class Ip
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
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @ORM\ManyToMany(targetEntity="OA", mappedBy="ips", cascade={"persist"})
     */
    private $oas;


    public function __construct(){

        $this->oas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addOa(OA $oa)
    {
        $this->oas[] = $oa;
    }
    public function getOas()
    {
        return $this->oas;
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
     * Set direccion
     *
     * @param string $direccion
     * @return Ip
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
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