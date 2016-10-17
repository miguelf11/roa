<?php

namespace ROA\ROABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ROA\ROABundle\Entity\Categoria;
use ROA\ROABundle\Form\CategoriaType;

/**
 * Categoria controller.
 *
 */
class CategoriaController extends Controller
{
    /**
     * Lists all Categoria entities.
     *
     */
    public function indexAction()
    {
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ROABundle:Categoria')->findAll();

        return $this->render('ROABundle:Categoria:index.html.twig', array(
            'entities' => $entities, 'usuario'=>$usuario, 'mensaje'=>$mensaje,
        ));
    }

    /**
     * Finds and displays a Categoria entity.
     *
     */
    public function showAction($id)
    {
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ROABundle:Categoria:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'mensaje' => $mensaje ));
    }

    /**
     * Displays a form to create a new Categoria entity.
     *
     */
    public function newAction()
    {
        
        $usuario = $this->get('security.context')->getToken()->getUser();
        $entity = new Categoria();
        $form   = $this->createForm(new CategoriaType(), $entity);

        return $this->render('ROABundle:Categoria:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'usuario' => $usuario,
        ));
    }

    /**
     * Creates a new Categoria entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Categoria();
        $form = $this->createForm(new CategoriaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->setFlash('mensaje', 'Categoria creada exitosamente!');

            return $this->redirect($this->generateUrl('categoria_show', array('id' => $entity->getId())));
        }

        return $this->render('ROABundle:Categoria:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Categoria entity.
     *
     */
    public function editAction($id)
    {
        
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $editForm = $this->createForm(new CategoriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ROABundle:Categoria:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'mensaje'=>$mensaje,
        ));
    }

    /**
     * Edits an existing Categoria entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        /*Subcategorias orginales*/
        $originalSubcategorias = array();
        foreach ($entity->getSubcategorias() as $subcategoria) {
            $originalSubcategorias[] = $subcategoria;
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoriaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            /*Eliminar Subcategorias*/
            foreach ($entity->getSubcategorias() as $subcategoria) {
                foreach ($originalSubcategorias as $key => $toDel) {
                    if ($toDel->getId() === $subcategoria->getId()) {
                        unset($originalSubcategorias[$key]);
                    }
                }
            }
            foreach ($originalSubcategorias as $subcategoria) {
                $em->remove($subcategoria);
            }

            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->setFlash('mensaje', 'Categoria editada exitosamente!');

            return $this->redirect($this->generateUrl('categoria_edit', array('id' => $id)));
        }

        return $this->render('ROABundle:Categoria:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
        ));
    }

    /**
     * Deletes a Categoria entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ROABundle:Categoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Categoria entity.');
            }

            $em->remove($entity);
            $em->flush();
            $mensaje = $this->getRequest()->getSession()->setFlash('mensaje', 'Categoria eliminada exitosamente!');
        }

        return $this->redirect($this->generateUrl('categoria', array('mensaje'=>$mensaje)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
