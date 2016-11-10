<?php

namespace ROA\ROABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ROA\ROABundle\Entity\Subcategoria;
use ROA\ROABundle\Form\SubcategoriaType;

/**
 * Subcategoria controller.
 *
 */
class SubcategoriaController extends Controller
{
    /**
     * Lists all Subcategoria entities.
     *
     */
    public function indexAction()
    {

        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ROABundle:Subcategoria')->findAll();

        return $this->render('ROABundle:Subcategoria:index.html.twig', array(
            'entities' => $entities,'usuario'=>$usuario, 'mensaje'=>$mensaje,
        ));
    }

    /**
     * Finds and displays a Subcategoria entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Subcategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subcategoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ROABundle:Subcategoria:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Subcategoria entity.
     *
     */
    public function newAction()
    {
        $entity = new Subcategoria();
        $form   = $this->createForm(new SubcategoriaType(), $entity);

        return $this->render('ROABundle:Subcategoria:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Subcategoria entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Subcategoria();
        $form = $this->createForm(new SubcategoriaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subcategoria_show', array('id' => $entity->getId())));
        }

        return $this->render('ROABundle:Subcategoria:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Subcategoria entity.
     *
     */
    public function editAction($id)
    {
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:Subcategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subcategoria entity.');
        }

        $editForm = $this->createForm(new SubcategoriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ROABundle:Subcategoria:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'mensaje'=>$mensaje,
        ));
    }

    /**
     * Edits an existing Subcategoria entity.
     *
     */
    public function updateAction(Request $request, $id)
    {

        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ROABundle:Subcategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subcategoria entity.');
        }


        /*Areas originales*/
        $originalAreas = array();
        foreach ($entity->getAreas() as $area) {
            $originalAreas[] = $area;
        }


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SubcategoriaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            /*Eliminar Areas*/
            foreach ($entity->getAreas() as $area) {
                foreach ($originalAreas as $key => $toDel) {
                    if ($toDel->getId() === $area->getId()) {
                        unset($originalAreas[$key]);
                    }
                }
            }
            foreach ($originalAreas as $area) {
                $em->remove($area);
            }

            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->setFlash('mensaje', 'Subcategoria editada exitosamente!');

            return $this->redirect($this->generateUrl('subcategoria_edit', array('id' => $id)));
        }

        return $this->render('ROABundle:Subcategoria:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'mensaje'=>$mensaje,
        ));
    }

    /**
     * Deletes a Subcategoria entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ROABundle:Subcategoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Subcategoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('subcategoria'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
