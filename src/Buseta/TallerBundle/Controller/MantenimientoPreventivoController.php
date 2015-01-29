<?php

namespace Buseta\TallerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Buseta\TallerBundle\Entity\MantenimientoPreventivo;
use Buseta\TallerBundle\Form\Type\MantenimientoPreventivoType;

/**
 * MantenimientoPreventivo controller.
 *
 * @Route("/mpreventivo")
 */
class MantenimientoPreventivoController extends Controller
{

    /**
     * Lists all MantenimientoPreventivo entities.
     *
     * @Route("/", name="mantenimientopreventivo", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaTallerBundle:MantenimientoPreventivo')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MantenimientoPreventivo entity.
     *
     * @Route("/", name="mantenimientopreventivo_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $entity = new MantenimientoPreventivo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mantenimientopreventivo_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MantenimientoPreventivo entity.
     *
     * @param MantenimientoPreventivo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MantenimientoPreventivo $entity)
    {
        $form = $this->createForm(new MantenimientoPreventivoType(), $entity, array(
            'action' => $this->generateUrl('mantenimientopreventivo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MantenimientoPreventivo entity.
     *
     * @Route("/new", name="mantenimientopreventivo_new", methods={"GET"})
     */
    public function newAction()
    {
        $entity = new MantenimientoPreventivo();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MantenimientoPreventivo entity.
     *
     * @Route("/{id}", name="mantenimientopreventivo_show", methods={"GET"})
     */
    public function showAction(MantenimientoPreventivo $entity)
    {
        $deleteForm = $this->createDeleteForm($entity->getId());

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MantenimientoPreventivo entity.
     *
     * @Route("/{id}/edit", name="mantenimientopreventivo_edit", methods={"GET"})
     */
    public function editAction(MantenimientoPreventivo $entity)
    {
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MantenimientoPreventivo entity.
    *
    * @param MantenimientoPreventivo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MantenimientoPreventivo $entity)
    {
        $form = $this->createForm(new MantenimientoPreventivoType(), $entity, array(
            'action' => $this->generateUrl('mantenimientopreventivo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MantenimientoPreventivo entity.
     *
     * @Route("/{id}", name="mantenimientopreventivo_update", methods={"PUT"})
     */
    public function updateAction(Request $request, MantenimientoPreventivo $entity)
    {
        $deleteForm = $this->createDeleteForm($entity->getId());
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->flush();

            return $this->redirect($this->generateUrl('mantenimientopreventivo_edit', array('id' => $entity->getId())));
        }

        return $this->render('', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MantenimientoPreventivo entity.
     *
     * @Route("/{id}", name="mantenimientopreventivo_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, MantenimientoPreventivo $entity)
    {
        $form = $this->createDeleteForm($entity->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mantenimientopreventivo'));
    }

    /**
     * Creates a form to delete a MantenimientoPreventivo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mantenimientopreventivo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
