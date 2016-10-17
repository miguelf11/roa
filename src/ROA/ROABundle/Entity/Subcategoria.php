<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subcategoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Entity\SubcategoriaRepository")
 */
class Subcategoria
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
     * @ORM\OneToMany(targetEntity="OA", mappedBy="subcategoria", cascade={"persist", "remove"})
     */
    private $oas;


    /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="subcategorias")
     * @ORM\JoinColumn(name="categoria", referencedColumnName="id")
     * @return integer
     */
    private $categoria;

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
     * @return Subcategoria
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


    public function setCategoria(\ROA\ROABundle\Entity\Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }
}
