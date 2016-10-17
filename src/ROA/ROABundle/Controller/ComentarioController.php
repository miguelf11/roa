<?php
namespace ROA\ROABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use ROA\ROABundle\Entity\Comentario;
use ROA\ROABundle\Entity\OA;
use ROA\ROABundle\Entity\Usuario;

use ROA\ROABundle\Form\ComentarioType;

class ComentarioController extends Controller
{

    public function newAction($id){

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();
        
        switch($format){
           
            case 'json':
                break;

            case 'xml':
                break;

            default: 

                $comentario_new = New Comentario();

                $em = $this->getDoctrine()->getEntityManager();
                $objeto = $em->getRepository('ROABundle:OA')->find($id);
                //$comentarios = $objeto->getComentarios();
                $comentarios = $em->getRepository('ROABundle:Comentario')->findComentariosPublicados($id);

        
                //Creación del formulario
                $Comentario_form = $this->createForm(new ComentarioType(), $comentario_new);

                if($this->getRequest()->getMethod() == 'POST'){

                    //Se le asigna al Objeto comentario_new los campos enviados en los formularios
                    $Comentario_form->bindRequest($this->getRequest());

                    //Validación de Formularios
                    if( $Comentario_form->isValid()){

                        //Persistencia y almacenamiento en Base de Datos
                        //$em = $this->getDoctrine()->getEntityManager();
                        //$objeto = $em->getRepository('ROABundle:OA')->find($id);
                        $comentario_new->setOa($objeto);
                        $comentario_new->setUsuario($usuario);
                        //$objeto->setComentario($comentario_new);
                        //$usuario_new->addRole($role); 
                        $em->persist($comentario_new);
                        $em->flush();

                        //$objeto = $em->getRepository('ROABundle:OA')->find($id);
                        //$comentarios = $objeto->getComentarios();
                       

                        /*$variables = array('error'=> $error,'usuario'=> $usuario, 'comentario_new'=>$comentario_new, 'objeto'=>$objeto, 'Comentario_form' => $Comentario_form->createView(), 'comentarios'=>$comentarios);*/
                
                        return $this->render('ROABundle:Comentario:create.html.twig', array('comentario_new' => $comentario_new));
                    }

                }
                //Variables que son pasadas a la vista
                $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario,
                    'objeto'=> $objeto,
                    'Comentario_form' => $Comentario_form->createView(),
                    'comentarios' => $comentarios);

                //$content = $this->renderView('ROABundle:Comentario:new.html.twig', $variables);
                return $this->render('ROABundle:Comentario:new.html.twig', $variables); 
                
            }
        //return new Response($content);
    }


    public function indexAction()
    {
        //$mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ROABundle:Comentario')->findComentariosNoPublicados();

        return $this->render('ROABundle:Comentario:index.html.twig', array(
            'entities' => $entities,
            'usuario' => $usuario,
            //'mensaje' => $mensaje,
        ));
    }


    public function editAction($id)
    {
        
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Comentario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comentario entity.');
        }

        $editForm = $this->createForm(new ComentarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ROABundle:Comentario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'mensaje' => $mensaje,
        ));
    }

    public function updateAction($id)
    {
       
        $request = $this->getRequest();
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Comentario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comentario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ComentarioType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            $fecha_publicacion = new \DateTime("now");
            $entity->setFecha_publicacion($fecha_publicacion);
            
            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->setFlash('mensaje', 'Comentario editado exitosamente!');

            return $this->redirect($this->generateUrl('comentario_edit_admin', array('id' => $id)));
        }

        return $this->render('ROABundle:OA:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            //'role' => $role,
        ));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
}
