<?php
namespace ROA\ROABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use ROA\ROABundle\Entity\Usuario;
use ROA\ROABundle\Entity\Role;
use ROA\ROABundle\Form\UsuarioType;

use Symfony\Component\HttpFoundation\RedirectResponse;

class PerfilController extends Controller
{

    public function newAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();
        
        switch($format){
           
            case 'json':
                break;

            case 'xml':
                break;

            default: 

                $usuario_new = New Usuario();
        
                //Creación del formulario
                $Usuario_form = $this->createForm(new UsuarioType(), $usuario_new, array('validation_groups'=>array('create')));

                if($this->getRequest()->getMethod() == 'POST'){

                    //Se le asigna al Objeto usuario_new los campos enviados en los formularios
                    $Usuario_form->bindRequest($this->getRequest());

                    //Validación de Formularios
                    if( $Usuario_form->isValid()){

                        $this->setSecurePassword($usuario_new);
                        $usuario_new->setActivacion(md5(uniqid(rand(), true)));

                        //Persistencia y almacenamiento en Base de Datos
                        $em = $this->getDoctrine()->getEntityManager();
                        $role = $em->getRepository('ROABundle:Role')->findOneByNombre('ROLE_NO_CONTRIBUYENTE');
                        $usuario_new->addRole($role); 
                        $em->persist($usuario_new);
                        $em->flush();

                        $this->enviar_activacion($usuario_new);

                        $variables = array('error'=> $error,'usuario'=> $usuario, 'usuario_new'=>$usuario_new, 'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());
                
                        return $this->render('ROABundle:Perfil:activar.html.twig', $variables);
                    }

                }else{

                    //Variables que son pasadas a la vista
                    $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario,
                    'Usuario_form' => $Usuario_form->createView(), 'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());

                    // Validación de la activación del correo
                    if ($this->getRequest()->query->get('email') && $this->getRequest()->query->get('activacion')){

                        $em = $this->getDoctrine()->getEntityManager(); 
                        $usuario_activar = $em->getRepository('ROABundle:Usuario')->findOneByActivacion($this->getRequest()->query->get('activacion'));
                        if($usuario_activar == false){
                            $variables['activacion_exitosa'] = '0';
                        }else{
                            $usuario_activar->setActivacion(null);
                            $em->persist($usuario_activar);
                            $em->flush();
                            $variables['activacion_exitosa'] = '1';
                            $variables['usuario_new'] = $usuario_activar;
                            $variables['message'] = "Usuario activado correctamente, Bienvenido";
                            return $this->render('ROABundle:Perfil:create.html.twig', $variables);
                        }
                        return $this->render('ROABundle:Perfil:create.html.twig', $variables);
                    }else{
                       $content = $this->renderView('ROABundle:Perfil:new.html.twig', $variables); 
                    }  
                }
            //Variables que son pasadas a la vista
            $variables = array(
            'error'=> $error,
            'usuario'=> $usuario,
            'Usuario_form' => $Usuario_form->createView(), 'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());
            $content = $this->renderView('ROABundle:Perfil:new.html.twig', $variables);   
            }
        return new Response($content);
    }
    public function createAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();
          
        $variables = array(
            'error'=> $error,
            'usuario'=> $usuario,
            'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());

        $content = $this->renderView('ROABundle:Perfil:create.html.twig', $variables);

        return new Response($content);

    }
    public function editAction($id){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        if( !($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) ){
            return $this->redirect($this->generateUrl('inicio', array()));
        }

        //Variables que son pasadas a la vista
        $variables = array('error'=> $error,'usuario'=> $usuario, 'contrasena_invalida'=>'', 'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());
        
        switch($format){
           
            case 'json':
                break;

            case 'xml':
                break;

            default: 

                $em = $this->getDoctrine()->getEntityManager();
                $usuario_edit = $em->getRepository('ROABundle:Usuario')->find($id);
        
                //Creación del formulario
                $Usuario_form = $this->createForm(new UsuarioType(), $usuario_edit, array('validation_groups'=>array('update')));

                if($this->getRequest()->getMethod() == 'POST'){

                    $contrasena_actual = $this->getRequest()->request->get("contrasena_actual");
                    $contrasena_actual = $this->encriptar($contrasena_actual, $usuario_edit->getSalt());

                    if ($contrasena_actual == $usuario_edit->getPassword()){ 

                        //Se le asigna al Objeto usuario_edit los campos enviados en los formularios
                        $Usuario_form->bindRequest($this->getRequest());

                        if ($usuario_edit->getPassword() == ""){
                            $usuario_edit->setPassword($contrasena_actual);

                        }else{
                            $this->setSecurePassword($usuario_edit);
                        }

                        //Validación de Formularios
                        if( $Usuario_form->isValid()){
                            //Persistencia y almacenamiento en Base de Datos
                            $em->persist($usuario_edit);
                            $em->flush();

                            $variables ['usuario_edit'] = $usuario_edit;
                    
                            return $this->render('ROABundle:Perfil:update.html.twig', $variables);
                        }

                    }else{
                            $variables['Usuario_form'] = $Usuario_form->createView();
                            $variables['contrasena_invalida'] = "La contrasena actual suministrada no es valida. Vuelve a intentarlo";
                            return $this->render('ROABundle:Perfil:edit.html.twig', $variables);
                    }

                }

                $variables['Usuario_form'] = $Usuario_form->createView();
                return $this->render('ROABundle:Perfil:edit.html.twig', $variables);
        }

    }

    public function recuperar_contrasenaAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $variables = array(
                'email_invalido' =>'',
                'error'=> $error,
                'usuario'=> $usuario,
                'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());

        $usuario_aux = New Usuario();
        $Usuario_form = $this->createForm(new UsuarioType(), $usuario_aux);
 
        $variables['paso'] = 1;

        if($this->getRequest()->getMethod() == 'GET'){

           $variables['Usuario_form'] = $Usuario_form->createView();
           $content = $this->renderView('ROABundle:Perfil:recuperar_contrasena.html.twig', $variables);

        }else{

            $Usuario_form->bindRequest($this->getRequest());
            $clave = $this->get('generador_clave')->getClave();

            //Cambio de contrasena del usuario
            $em = $this->getDoctrine()->getEntityManager();
            $usuario_aux = $em->getRepository('ROABundle:Usuario')->findOneByEmail($usuario_aux->getEmail());

            if (($usuario_aux)==null){
                $variables['Usuario_form'] = $Usuario_form->createView();
                $variables['email_invalido'] = 'Este email no esta registrado en el sistema. Intentalo de nuevo';
                return $this->render('ROABundle:Perfil:recuperar_contrasena.html.twig', $variables);
            }

            $usuario_aux->setPassword($clave);
            $this->setSecurePassword($usuario_aux);
            $em->persist($usuario_aux);
            $em->flush();

            //Envio de email
            $mensaje = \Swift_Message::newInstance()
                    ->setSubject('ROACAR - Restauracion de Contrasena')
                    ->setFrom('uead.cienciasucv@gmail.com')
                    ->setTo($usuario_aux->getEmail())
                    ->setBody(
                            $this->renderView(
                                'ROABundle:Perfil:email.html.twig',
                                array('clave' => $clave)), 'text/html');
            $this->get('mailer')->send($mensaje);

            $variables['paso'] = 2;
            $content = $this->renderView('ROABundle:Perfil:recuperar_contrasena.html.twig', $variables);

        }
        return new Response($content);

    }


    private function setSecurePassword(&$entity) {
        $entity->setSalt(md5(time()));
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }

    private function encriptar($password, $salt){
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($password, $salt);
        return $password;

    }

    private function enviar_activacion(Usuario $usuario){

        $email = urlencode($usuario->getEmail());
        //Envio de email
        $mensaje = \Swift_Message::newInstance()
                ->setSubject('Activacion de tu cuenta de ROACAR')
                ->setFrom('uead.cienciasucv@gmail.com')
                ->setTo($usuario->getEmail())
                ->setBody(
                        $this->renderView(
                            'ROABundle:Perfil:email_activacion.html.twig',
                            array('usuario' => $usuario, 'email'=>$email)), 'text/html');

        $this->get('mailer')->send($mensaje);
    }
}
