<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

//use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

//No se si esto funciona
//use ROA\ROABundle\Entity\General;

/**
 * ROA\ROABundle\Entity\OA
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Repository\OARepository")
 * @ORM\HasLifecycleCallbacks
 */
class OA
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
     * @var string $titulo
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     * @Assert\NotBlank(message="Campo requerido", groups={"create", "update"})
     */
    private $titulo;


    /**
     * @var \DateTime $fecha_publicacion
     *
     * @ORM\Column(name="fecha_publicacion", type="datetime", nullable=true)
     */
    private $fecha_publicacion;


    /**
     * @ORM\Column(name="ano", type="string", nullable=true)
     */
    private $ano;

     /**
     * @Assert\File(
     *     maxSize = "900M",
     *     maxSizeMessage = "Archivo muy grande",
     *     mimeTypes = {"application/pdf", "image/png", "image/jpeg", "audio/x-vorbis+ogg", "video/mp4", "application/zip", "video/webm", "video/ogg", "video/avi", "video/msvideo", "video/x-msvideo", "audio/ogg", "audio/flac", "audio/opus", "audio/webm", "application/vnd.ms-powerpoint", "application/vnd.ms-powerpoint"},
     *     mimeTypesMessage = "Formato inválido",
     *     groups={"create", "update"}
     * )
     * @Assert\NotBlank(message="Campo requerido", groups={"create"})
     */
    public $file;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $original_name;


    /**
     * @ORM\OneToOne(targetEntity="General", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="general_id", referencedColumnName="id")
     */
    private $general;

    /**
     * @ORM\OneToOne(targetEntity="CicloVida", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="ciclovida_id", referencedColumnName="id")
     */
    private $ciclovida;

    /**
     * @ORM\OneToOne(targetEntity="MetaMetadata", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="metametadata_id", referencedColumnName="id")
     */
    private $metametadata;

    /**
     * @ORM\OneToOne(targetEntity="Tecnico", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="tecnico_id", referencedColumnName="id")
     */
    private $tecnico;

    /**
     * @ORM\OneToOne(targetEntity="Educacional", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="educacional_id", referencedColumnName="id")
     */
    private $educacional;

    /**
     * @ORM\OneToOne(targetEntity="Derechos", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="derechos_id", referencedColumnName="id")
     */
    private $derechos;

    //cascade = {"remove"}


    /**
     * @ORM\OneToMany(targetEntity="Anotacion", mappedBy="oa", cascade={"persist","remove"})
     */
    private $anotaciones;

    /**
     * @ORM\OneToMany(targetEntity="Relacion", mappedBy="oa", cascade={"persist","remove"})
     */
    private $relaciones;

    /**
     * @ORM\OneToMany(targetEntity="Clasificacion", mappedBy="oa", cascade={"persist","remove"})
     */
    private $clasificaciones;


    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="oa", cascade={"persist", "remove"})
     */
    private $comentarios;


    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_status_OA", referencedColumnName="id")
     * @return integer
     */
    private $status;


    /**
     * @ORM\ManyToOne(targetEntity="Subcategoria", inversedBy="oas")
     * @ORM\JoinColumn(name="subcategoria_id", referencedColumnName="id")
     * @return integer
     */
    private $subcategoria;



    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="oas")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Campo requerido", groups={"create", "update"})
     * @return integer
     */
    private $area;



    /**
     * @ORM\Column(name="puntuacion", type="integer", nullable=true)
     */
    private $puntuacion;

    /**
     * @ORM\Column(name="num_descargas", type="integer", nullable=true)
     */
    private $num_descargas;


    /**
     * @ORM\ManyToMany(targetEntity="Ip", inversedBy="oas", cascade={"persist"})
     * @ORM\JoinTable(name="oas_ips")
     */
    protected $ips;


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
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="oas")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @return integer
     */
    private $usuario;


    /*public function setFile(File $file = null)
    {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }*/

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return OA
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
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

    public function setAno($ano)
    {
        $this->ano = $ano;
    
        return $this;
    }

    public function getAno()
    {
        return $this->ano;
    }


    //public function setGeneral(General $general)
    public function setGeneral(\ROA\ROABundle\Entity\General $general)
    {
        $this->general = $general;
    }

    public function getGeneral()
    {
        return $this->general;
    }

    public function setCiclovida(\ROA\ROABundle\Entity\CicloVida $ciclovida)
    {
        $this->ciclovida = $ciclovida;
    }

    public function getCiclovida()
    {
        return $this->ciclovida;
    }

    public function setMetametadata(\ROA\ROABundle\Entity\MetaMetadata $metametadata)
    {
        $this->metametadata = $metametadata;
    }

    public function getMetametadata()
    {
        return $this->metametadata;
    }

    public function setTecnico(\ROA\ROABundle\Entity\Tecnico $tecnico)
    {
        $this->tecnico = $tecnico;
    }

    public function getTecnico()
    {
        return $this->tecnico;
    }

    public function setEducacional(\ROA\ROABundle\Entity\Educacional $educacional)
    {
        $this->educacional = $educacional;
    }

    public function getEducacional()
    {
        return $this->educacional;
    }

    public function setDerechos(\ROA\ROABundle\Entity\Derechos $derechos)
    {
        $this->derechos = $derechos;
    }

    public function getDerechos()
    {
        return $this->derechos;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
        return $this;
    }

    public function getPuntuacion(){
        return $this->puntuacion;
    }

    public function setPuntuacion($puntuacion){
        $this->puntuacion = $puntuacion;
        return $this;
    }

    public function getNumDescargas(){
        return $this->num_descargas;
    }

    public function setNumDescargas($num_descargas){
        $this->num_descargas = $num_descargas;
        return $this;
    }

    //\ROA\ROABundle\Entity\Subcategoria $subcategoria
    public function setSubcategoria($subcategoria)
    {
        $this->subcategoria = $subcategoria;
    }

    public function getSubcategoria()
    {
        return $this->subcategoria;
    }

    //\ROA\ROABundle\Entity\Area $area
    public function setArea($area)
    {
        $this->area = $area;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function __construct()
    {
        $this->general = New \ROA\ROABundle\Entity\General();

        $this->ciclovida = New \ROA\ROABundle\Entity\CicloVida();

        $this->metametadata = New \ROA\ROABundle\Entity\MetaMetadata();

        $this->tecnico = New \ROA\ROABundle\Entity\Tecnico();

        $this->educacional = New \ROA\ROABundle\Entity\Educacional();

        $this->derechos = New \ROA\ROABundle\Entity\Derechos();

        //$this->relacion = New \ROA\ROABundle\Entity\Relacion();

        $this->anotaciones = new \Doctrine\Common\Collections\ArrayCollection();

        $this->relaciones = new \Doctrine\Common\Collections\ArrayCollection();

        $this->clasificaciones = new \Doctrine\Common\Collections\ArrayCollection();

        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();

        $this->ips = new \Doctrine\Common\Collections\ArrayCollection();

    }
   /* public function addAnotacion(\ROA\ROABundle\Entity\Anotacion $anotacion)
    {
        $this->anotacion[] = $anotacion;
    }*/

    public function getIps()
    {
        return $this->ips;
    }
    public function addIp(Ip $ip)
    {
        $ip->addOa($this); // synchronously updating inverse side
        $this->ips[] = $ip;
    }

    public function removeIp(Ip $ip)
    {
        
    }
    public function existeIp(Ip $ip){

        foreach ($this->ips as $ip_aux) {
            if ($ip_aux->getDireccion() == $ip->getDireccion()){
                return true;
            }
        }
        return false;    
    }

    public function IncrementarNum_descargas(){
        $this->num_descargas++;
    }


    public function getAnotaciones()
    {
        //return $this->anotaciones->toArray();
        return $this->anotaciones;
    }
    public function setAnotaciones($anotaciones)
    {
        foreach ($anotaciones as $anotacion) {
            $anotacion->setOa($this);
        }
            $this->anotaciones = $anotaciones;
    }


    public function getClasificaciones()
    {
        //return $this->anotaciones->toArray();
        return $this->clasificaciones;
    }
    public function setClasificaciones($clasificaciones)
    {
        foreach ($clasificaciones as $clasificacion) {
            $clasificacion->setOa($this);
        }
            $this->clasificaciones = $clasificaciones;
    }


    public function getComentarios()
    {
        //return $this->anotaciones->toArray();
        return $this->comentarios;
    }
    public function setComentarios($comentarios)
    {
        foreach ($comentarios as $comentario) {
            $comentario->setOa($this);
        }
            $this->comentarios = $comentarios;
    }

     public function getRelaciones()
    {
        //return $this->requerimientos->toArray();
        return $this->relaciones;
    }
    public function setRelaciones($relaciones)
    {
        foreach ($relaciones as $relacion) {
            $relacion->setOa($this);
        }
        $this->relaciones = $relaciones;
    }
    /*public function addRelacion(\ROA\ROABundle\Entity\Relacion $relacion)
    {
        $this->relaciones[] = $relacion;
    }*/
    public function setUsuario(\ROA\ROABundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }





    //MANEJO DE LA RUTA DEL ARCHIVO

    public function getPath(){
        return $this->path;
    }

    /*public function setPath($path){
        $this->path = $path;
    }*/


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
        return 'uploads/objetos';
    }




    //RETROLLAMADAS

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
            $this->original_name = $this->file->getClientOriginalName();
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



    public function getOriginal_name(){
        return $this->original_name;
    }

    public function setOriginal_name($name){
        $this->original_name = $name;
    }

    /*public function Original_name_noExtension(){
        $aux = explode('.', $this->getOriginal_name());
        return $aux[0];
    }*/


    /*public function addClasificacion(\ROA\ROABundle\Entity\Clasificacion $clasificacion)
    {
        $this->clasificacion[] = $clasificacion;
    }

    public function getClasificacion()
    {
        return $this->clasificacion->toArray();
        //return $this->clasificacion;
    }*/

    /*public function getAnotacion()
    {
        return $this->anotacion->toArray();
        //return $this->anotacion;
    }

    public function addRelacion(\ROA\ROABundle\Entity\Relacion $relacion)
    {
        $this->relacion[] = $relacion;
    }*/


    /**
     * Set fecha_publicacion
     *
     * @param \DateTime $fechaPublicacion
     * @return OA
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fecha_publicacion = $fechaPublicacion;
    
        return $this;
    }

    /**
     * Get fecha_publicacion
     *
     * @return \DateTime 
     */
    public function getFechaPublicacion()
    {
        return $this->fecha_publicacion;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return OA
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Set original_name
     *
     * @param string $originalName
     * @return OA
     */
    public function setOriginalName($originalName)
    {
        $this->original_name = $originalName;
    
        return $this;
    }

    /**
     * Get original_name
     *
     * @return string 
     */
    public function getOriginalName()
    {
        return $this->original_name;
    }

    /**
     * Add anotaciones
     *
     * @param \ROA\ROABundle\Entity\Anotacion $anotaciones
     * @return OA
     */
    public function addAnotacione(\ROA\ROABundle\Entity\Anotacion $anotaciones)
    {
        $this->anotaciones[] = $anotaciones;
    
        return $this;
    }

    /**
     * Remove anotaciones
     *
     * @param \ROA\ROABundle\Entity\Anotacion $anotaciones
     */
    public function removeAnotacione(\ROA\ROABundle\Entity\Anotacion $anotaciones)
    {
        $this->anotaciones->removeElement($anotaciones);
    }

    /**
     * Add relaciones
     *
     * @param \ROA\ROABundle\Entity\Relacion $relaciones
     * @return OA
     */
    public function addRelacione(\ROA\ROABundle\Entity\Relacion $relaciones)
    {
        $this->relaciones[] = $relaciones;
    
        return $this;
    }

    /**
     * Remove relaciones
     *
     * @param \ROA\ROABundle\Entity\Relacion $relaciones
     */
    public function removeRelacione(\ROA\ROABundle\Entity\Relacion $relaciones)
    {
        $this->relaciones->removeElement($relaciones);
    }

    /**
     * Add clasificaciones
     *
     * @param \ROA\ROABundle\Entity\Clasificacion $clasificaciones
     * @return OA
     */
    public function addClasificacione(\ROA\ROABundle\Entity\Clasificacion $clasificaciones)
    {
        $this->clasificaciones[] = $clasificaciones;
    
        return $this;
    }

    /**
     * Remove clasificaciones
     *
     * @param \ROA\ROABundle\Entity\Clasificacion $clasificaciones
     */
    public function removeClasificacione(\ROA\ROABundle\Entity\Clasificacion $clasificaciones)
    {
        $this->clasificaciones->removeElement($clasificaciones);
    }

    /**
     * Add comentarios
     *
     * @param \ROA\ROABundle\Entity\Comentario $comentarios
     * @return OA
     */
    public function addComentario(\ROA\ROABundle\Entity\Comentario $comentarios)
    {
        $this->comentarios[] = $comentarios;
    
        return $this;
    }

    /**
     * Remove comentarios
     *
     * @param \ROA\ROABundle\Entity\Comentario $comentarios
     */
    public function removeComentario(\ROA\ROABundle\Entity\Comentario $comentarios)
    {
        $this->comentarios->removeElement($comentarios);
    }
}