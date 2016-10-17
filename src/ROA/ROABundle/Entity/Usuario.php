<?php

namespace ROA\ROABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\User\UserInterface;

//use ROA\ROABundle\Validator\Validator\Cedula;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ROA\ROABundle\Entity\Usuario
 *
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="ROA\ROABundle\Entity\UsuarioRepository")
 * @UniqueEntity(fields={"email"}, message="Este email esta en uso", groups={"create"})
 * @ORM\HasLifecycleCallbacks
 */

class Usuario implements UserInterface, \Serializable{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;

    /**
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    protected $salt;

    /**
     * @ORM\Column(name="activacion", type="string", length=32, nullable=true)
     */
    protected $activacion;

	/**
	 * @ORM\Column(type="string", length=60)
     * @Assert\Email(message="Email inválido", groups={"create", "update"})
     * @Assert\NotBlank(message="Campo requerido", groups={"create", "update"})
	 */
	protected $email;
	/**
	 * @ORM\Column(type="string", length=25)
     * @Assert\Email()
     * @Assert\NotBlank(message="Campo requerido", groups={"create", "update"})
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Nombre inválido",
     *     groups={"create", "update"}
     * )
     */
	protected $nombre;
	/**
	 * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Campo requerido", groups={"create", "update"})
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Apellido inválido",
     *     groups={"create", "update"}
     * )
	 */
	protected $apellido;


    /**
     * @ORM\ManyToOne(targetEntity="Vocablo")
     * @ORM\JoinColumn(name="vocablo_id_tipo_usuario", referencedColumnName="id")
     * @return integer
     */
    protected $tipo_usuario;

	/**
	 * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Campo requerido", groups={"create"})
	 */
	protected $password;

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


    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="usuario_role",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;


    /**
     * @ORM\OneToMany(targetEntity="OA", mappedBy="usuario", cascade={"persist", "remove"})
     */
    protected $oas;


    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $comentarios;




    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();

        $this->oas = new \Doctrine\Common\Collections\ArrayCollection();

        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getUsername(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getSalt(){
        //return false;
        return $this->salt;
    }
    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
    public function eraseCredentials(){
        return false;
    }
    public function getActivacion(){
        return $this->activacion;
    }
    public function setActivacion($activacion){
        $this->activacion = $activacion;
        return $this;
    }



    /*public function equals (UserInterface $user){
        return $this->getUsername() ==  $user->getUsername();  
    }*/

    /**
     * Compares this user to another to determine if they are the same.
     *
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user) {
        return md5($this->getUsername()) == md5($user->getUsername());

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
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
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
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }


    
    public function setTipoUsuario($tipo_usuario)
    {
        $this->tipo_usuario = $tipo_usuario;
    
        return $this;
    }

    
    public function getTipoUsuario()
    {
        return $this->tipo_usuario;
    }
    
   /**
     * Get roles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

   public function addRole(\ROA\ROABundle\Entity\Role $role)
    {
        $this->roles[] = $role;
    }

    public function removeRole(\ROA\ROABundle\Entity\Role $role)
    {
        $roles = $this->getRoles();
        foreach ($roles as $key => $aux) {
            if ($aux == $role){
                unset($roles[$key]);
                $roles = array_values($roles);
                var_dump($roles);
            }
        }
        $this->setRoles($roles);
    }

    public function esContribuyente(){
        //$roles = $this->getRoles();
        foreach ($this->getRoles() as $role){
            if($role->getDescripcion() == 'Contribuyente'){
                return true;
            }else{
                return false;
            }
        }
    }

    public function changeToContribuyente(Role $role_contribuyente){
        foreach ($this->getRoles() as $role){
            if($role->getDescripcion()== 'No Contribuyente'){
                $this->removeRole($role);
                $this->addRole($role_contribuyente);
            }
        }
    }

    public function changeToNoContribuyente(Role $role_no_contribuyente){
        foreach ($this->getRoles() as $role){
            if($role->getDescripcion()== 'Contribuyente'){
                $this->removeRole($role);
                $this->addRole($role_no_contribuyente);
            }
        }

    }

    public function popRole(){
        $array_roles = $this->roles->toArray();
        $role = array_pop($array_roles);
        return $role->getDescripcion(); 
    }

  /* public function setRoles(\ROA\ROABundle\Entity\Role $role)
    {
        
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles[] = $role;
    }*/

   public function setRoles($roles)
    {
        
        $this->roles = $roles;
        return $this->roles;
        //$this->roles[] = $role;
    }



    /*public function setRolesCollection(\Doctrine\Common\Collections\ArrayCollection $collection)
{
    $this->setRoles($collection->toArray());

    return $this;
}*/





    public function getOas()
    {
        //return $this->anotaciones->toArray();
        return $this->oas;
    }
    public function getOasArray(){
        return $this->oas->toArray();
    }
    public function addOa(\ROA\ROABundle\Entity\OA $oa)
    {
        $this->oas[] = $oa;
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
        return 'usuarios/fotos_perfil';
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


    public function serialize()
    {
        /*
         * ! Don't serialize $roles field !
         */
        return \serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
        ) = \unserialize($serialized);
    }


    public function getComentarios()
    {
        //return $this->anotaciones->toArray();
        return $this->comentarios;
    }
    public function setComentarios($comentarios)
    {
        foreach ($comentarios as $comentario) {
            $comentario->setUsuario($this);
        }
            $this->comentarios = $comentarios;
    }
  
}