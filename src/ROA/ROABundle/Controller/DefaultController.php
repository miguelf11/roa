<?php

namespace ROA\ROABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\JsonResponse;

use ROA\ROABundle\Entity\Usuario;
use ROA\ROABundle\Entity\Categoria;

/*use ROA\ROABundle\Servicios\HelloService;*/

class DefaultController extends Controller
{
	 public function indexAction()
    {

        $request = $this->getRequest();
        $session = $request->getSession();

        $error = $request->getSession()->getFlash('error');

        $usuario = $this->get('security.context')->getToken()->getUser();

        $variables = array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'usuario'          => $usuario,
            //'accesibilidad' => $accesibilidad,
            'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());
            //'mensaje'       => 'Usuario o Contraseña incorrecta',);
        
        return $this->render('ROABundle:Default:index.html.twig', $variables);
        
    }
     public function layoutAction()
    {   
        $request = $this->getRequest();
        $session = $request->getSession();

        /*if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
            $user = $this->get('security.context')->getToken()->getUser();
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $usuario = $this->get('security.context')->getToken()->getUser();
        }*/

        $error = $request->getSession()->getFlash('error');

        $usuario = $this->get('security.context')->getToken()->getUser();

         return $this->render('ROABundle::layout.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'usuario'       => $usuario,
            //'mensaje'       => 'Usuario o Contraseña incorrecta',
        ));
        
    }
    public function usuariosAction($id)
    {

        $request = $this->getRequest();
        $session = $request->getSession();

        $error = $request->getSession()->getFlash('error');
        
        $usuario = $this->get('security.context')->getToken()->getUser();

    	$em = $this->getDoctrine()->getEntityManager();
        $usuario2 = $em->getRepository('ROABundle:Usuario')->findOneByNombre('Juan');
        $roles = $usuario2->getRoles();

        $variables = array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'usuario'       => $usuario,
            'mensaje'       => 'Usuario o Contraseña incorrecta',
            'usuario2'       => $usuario2,
            'roles'       => $roles,
        );
        return $this->render('ROABundle:Default:usuarios.html.twig', $variables);

    }
    public function loginAction(){

        print_r("expression");
        exit();
        $request = $this->getRequest();
        $session = $request->getSession();


        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

         return $this->render('ROABundle:Default:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
    public function adminAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

         $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario);

        return $this->render('ROABundle:Default:admin.html.twig', $variables);

    }

    public function politicasAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

         $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario,
                    'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());

        return $this->render('ROABundle:Default:politicas.html.twig', $variables); 
    }

    public function accesibilidadAction(Request $request){

        $referer = $request->headers->get('referer');
        if ($request->getSession()->get('accesibilidad')){
            $accesibilidad = $request->getSession()->get('accesibilidad');
            if($accesibilidad == 'alto_contraste'){
                $request->getSession()->set('accesibilidad', 'normal');
            }else{
               $request->getSession()->set('accesibilidad', 'alto_contraste'); 
            }
        }else{
            $request->getSession()->set('accesibilidad', 'alto_contraste'); 
        }
        return new RedirectResponse($referer);
    }

    public function busquedaAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getEntityManager();

        $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario,
                    'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());

        if($this->getRequest()->getMethod() == 'POST'){

            $request = $this->getRequest(); 
            $subcategoria = $request->request->get('subcategoria');
            $ano = $request->request->get('ano');
            $autor = $request->request->get('autor');
            $titulo = $request->request->get('titulo');

            $aux = explode(' ', $autor);
            $autor = "";
            for ($i = 0; $i< count($aux); $i++){
                $autor = $autor."'".$aux[$i]."'";
                if ($i + 1 < count($aux)){
                    $autor = $autor.",";
                }
            } 
            
            $objetos = $em->getRepository('ROABundle:OA')->findAvanzada($subcategoria, $autor, $ano, $titulo);
            $variables['objetos'] = $objetos;
            return $this->render('ROABundle:Default:resultados.html.twig', $variables);

        }

        return $this->render('ROABundle:Default:busqueda.html.twig', $variables); 

    }

    public function recientesAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getEntityManager();
        $objetos = $em->getRepository('ROABundle:OA')->findRecientes(3);

         $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario,
                    'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll(),
                    'objetos'=>$objetos);

        return $this->render('ROABundle:Default:recientes.html.twig', $variables); 
    }

    public function mas_descargadosAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getEntityManager();
        $objetos = $em->getRepository('ROABundle:OA')->findMas_descargados(3);

         $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario,
                    'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll(),
                    'objetos' => $objetos);

        return $this->render('ROABundle:Default:mas_descargados.html.twig', $variables); 

    }

    public function creditosAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $variables = array(
                'error'=> $error,
                'usuario'=> $usuario,
                'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());

        return $this->render('ROABundle:Default:creditos.html.twig', $variables);  
    }


    public function sobre_roacarAction(){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $variables = array(
                'error'=> $error,
                'usuario'=> $usuario,
                'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());

        return $this->render('ROABundle:Default:sobre_roacar.html.twig', $variables);  
    }


    public function emailAction(){

        return $this->render('ROABundle:Default:email_insercion_OA.html.twig', array()); 
    }

    public function loginserviceAction(){

        $request = $this->getRequest();
        $usuario = array(); 


        if( $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){

            $user = $this->get('security.context')->getToken()->getUser();
            $usuario = $this->setUsuario($user);

        }else{

            if ($request->request->get('autenticar')){
                $_username = $request->request->get("_username");
                $_password = $request->request->get("_password");

                $user = $this->getDoctrine()->getEntityManager()->getRepository('ROABundle:Usuario')->findOneByEmail($_username);
                if (!($user)){
                    $usuario['logeado'] = '0'; 
                }else{

                    $_password = $this->encriptar($_password, $user->getSalt());
                    if ($_password == $user->getPassword()){
                        $usuario = $this->setUsuario($user);
                    }else{
                       $usuario['logeado'] = '0'; 
                    }  
                }
            }else{
                $usuario['logeado'] = '0'; 
            }  
        }    
        return new JsonResponse($usuario);
    }

    private function setUsuario($user){

        $usuario = array();
        $usuario['logeado'] = '1';
        $usuario['nombre'] = $user->getNombre();
        $usuario['apellido'] = $user->getApellido();
        $usuario['email'] = $user->getEmail();
        return $usuario;
    }

    private function encriptar($password, $salt){
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($password, $salt);
        return $password;
    }

}
