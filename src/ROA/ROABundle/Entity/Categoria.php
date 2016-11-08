<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\CategoriaRepository")
 */
class Categoria
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
     * @ORM\OneToMany(targetEntity="Subcategoria", mappedBy="categoria", cascade={"persist","remove"})
     */
    private $subcategorias;



    public function __construct(){

        $this->subcategorias = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getSubcategorias()
    {
        //return $this->anotaciones->toArray();
        return $this->subcategorias;
    }

    public function setSubcategorias($subcategorias)
    {
        foreach ($subcategorias as $subcategoria) {
            $subcategoria->setCategoria($this);
        }
        $this->subcategorias = $subcategorias;
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
     * @return Categoria
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
     * Add subcategorias
     *
     * @param \ROA\ROABundle\Entity\Subcategoria $subcategorias
     * @return Categoria
     */
    public function addSubcategoria(\ROA\ROABundle\Entity\Subcategoria $subcategorias)
    {
        $this->subcategorias[] = $subcategorias;
    
        return $this;
    }

    /**
     * Remove subcategorias
     *
     * @param \ROA\ROABundle\Entity\Subcategoria $subcategorias
     */
    public function removeSubcategoria(\ROA\ROABundle\Entity\Subcategoria $subcategorias)
    {
        $this->subcategorias->removeElement($subcategorias);
    }
}