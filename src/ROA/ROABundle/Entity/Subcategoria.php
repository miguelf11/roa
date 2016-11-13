<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Subcategoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Entity\SubcategoriaRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=500)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="OA", mappedBy="subcategoria", cascade={"persist", "remove"})
     */
    private $oas;


    /**
     * @ORM\OneToMany(targetEntity="Area", mappedBy="subcategoria", cascade={"persist","remove"})
     */
    private $areas;


    /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="subcategorias")
     * @ORM\JoinColumn(name="categoria", referencedColumnName="id")
     * @return integer
     */
    private $categoria;



    /**
     * @Assert\File(
     *     maxSize = "1M",
     *     maxSizeMessage = "Archivo muy grande",
     *     mimeTypes = {"image/png", "image/jpeg"},
     *     mimeTypesMessage = "Formato inválido",
     *     groups={"create", "update"}
     * )
     */
    public $file;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;






    public function __construct(){

        $this->oas = new \Doctrine\Common\Collections\ArrayCollection();

        $this->areas = new \Doctrine\Common\Collections\ArrayCollection();

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


    public function getAreas()
    {
        //return $this->anotaciones->toArray();
        return $this->areas;
    }

    public function setAreas($areas)
    {
        foreach ($areas as $area) {
            $area->setSubcategoria($this);
        }
        $this->areas = $areas;
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Subcategoria
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



    //MANEJO DE LA RUTA DEL ARCHIVO

    public function getPath(){
        return $this->path;
    }


    /**
     * Set path
     *
     * @param string $path
     * @return Usuario
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }


    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'subcategorias/imagenes';
    }




    //RETROLLAMADAS(CALLBACKS)

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }



    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // haz lo que quieras para generar un nombre único
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();
            //$this->original_name = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // si hay un error al mover el archivo, move() automáticamente
        // envía una excepción. Esta impedirá que la entidad se persista
        // en la base de datos en caso de error
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);

    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }


}