<?php

namespace ROA\ROABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ROA\ROABundle\Entity\Usuario;
use ROA\ROABundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{
    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction($role)
    {
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ROABundle:Usuario')->findPorRole2($role);
        
        //$entities = $em->getRepository('ROABundle:Usuario')->findPorRole('ROLE_ESTUDIANTE');

        return $this->render('ROABundle:Usuario:index.html.twig', array(
            'entities' => $entities,
            'usuario' => $usuario,
            'role' => $role,
            'mensaje' => $mensaje,
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($role, $id)
    {
        
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ROABundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(), 
            'usuario' => $usuario,
            'role' => $role,  
            'mensaje' => $mensaje,     
            ));
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction($role)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $entity = new Usuario();
        $form   = $this->createForm(new UsuarioType(), $entity);

        return $this->render('ROABundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'usuario' => $usuario,
            'role' => $role,
        ));
    }

    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction($role, Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $entity  = new Usuario();
        $form = $this->createForm(new UsuarioType(), $entity, array('validation_groups'=>array('create')));
        $form->bind($request);

        if ($form->isValid()) {

            $this->setSecurePassword($entity);
            $entity->setActivacion(null);

            $em = $this->getDoctrine()->getManager();
            //if ($role == 'prof'){
                //$role_user = $em->getRepository('ROABundle:Role')->findOneByDescripcion($role);
            //}else{
               // $role_user = $em->getRepository('ROABundle:Role')->findOneByNombre('ROLE_ESTUDIANTE');
            //}
            //$entity->addRole($role_user); 
            $role_user = $em->getRepository('ROABundle:Role')->findOneByNombre('ROLE_NO_CONTRIBUYENTE');
            $entity->addRole($role_user); 
            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->setFlash('mensaje', 'Usuario creado exitosamente!');

            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId(), 'role'=>$role)));
        }

        return $this->render('ROABundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'usuario' => $usuario,
            'role' => $role
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($role, $id)
    {
        
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Usuario invalido');
        }

        $editForm = $this->createForm(new UsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ROABundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'role' => $role,
            'mensaje' => $mensaje,
            'contrasena_invalida'=>'',
        ));
    }

    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction($role, Request $request, $id)
    {

        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Usuario Invalido');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UsuarioType(), $entity, array('validation_groups'=>array('update')));

        $contrasena_actual = $this->getRequest()->request->get("contrasena_actual");
        $contrasena_actual = $this->encriptar($contrasena_actual, $entity->getSalt());

        if ($contrasena_actual == $entity->getPassword()){ 

            $editForm->bind($request);
            if ($entity->getPassword() == ""){
                $entity->setPassword($contrasena_actual);
            }else{
                $this->setSecurePassword($entity);
            }

            //$editForm->bind($request);

            if ($editForm->isValid()) {
                $em->persist($entity);
                $em->flush();

                $this->getRequest()->getSession()->setFlash('mensaje', 'Usuario editado exitosamente!');

                return $this->redirect($this->generateUrl('usuario_edit', array('id' => $id, 'role'=>$role)));
            }

            return $this->render('ROABundle:Usuario:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'usuario' => $usuario,
                'role' => $role,
                'mensaje'=>'',
                'contrasena_invalida'=> ''
            ));

        }else{

            $variables = array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'usuario' => $usuario,
                'role' => $role,
                'mensaje'=>'',
                'contrasena_invalida' => 'La contrasena actual suministrada no es valida. Vuelve a intentarlo',
            );
            return $this->render('ROABundle:Usuario:edit.html.twig', $variables);
        }
    }

    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction($role, Request $request, $id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ROABundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();

            $mensaje = $this->getRequest()->getSession()->setFlash('mensaje', 'Usuario eliminado exitosamente!');

        }

        return $this->redirect($this->generateUrl('usuario', array('role'=>$role, 'mensaje'=>$mensaje)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
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
}
