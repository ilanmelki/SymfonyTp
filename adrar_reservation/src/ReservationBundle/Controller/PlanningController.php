<?php

namespace ReservationBundle\Controller;

use ReservationBundle\Entity\Planning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Planning controller.
 *
 * @Route("planning")
 */
class PlanningController extends Controller
{
    /**
     * Lists all planning entities.
     *
     * @Route("/", name="planning_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plannings = $em->getRepository('ReservationBundle:Planning')->findAll();

        return $this->render('planning/index.html.twig', array(
            'plannings' => $plannings,
        ));
    }

    /**
     * Creates a new planning entity.
     *
     * @Route("/new", name="planning_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $planning = new Planning();
        $form = $this->createForm('ReservationBundle\Form\PlanningType', $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planning);
            $em->flush();

            return $this->redirectToRoute('planning_show', array('id' => $planning->getId()));
        }

        return $this->render('planning/new.html.twig', array(
            'planning' => $planning,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a planning entity.
     *
     * @Route("/{id}", name="planning_show")
     * @Method("GET")
     */
    public function showAction(Planning $planning)
    {
        $deleteForm = $this->createDeleteForm($planning);

        return $this->render('planning/show.html.twig', array(
            'planning' => $planning,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing planning entity.
     *
     * @Route("/{id}/edit", name="planning_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Planning $planning)
    {
        $deleteForm = $this->createDeleteForm($planning);
        $editForm = $this->createForm('ReservationBundle\Form\PlanningType', $planning);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planning_edit', array('id' => $planning->getId()));
        }

        return $this->render('planning/edit.html.twig', array(
            'planning' => $planning,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a planning entity.
     *
     * @Route("/{id}", name="planning_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Planning $planning)
    {
        $form = $this->createDeleteForm($planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planning);
            $em->flush();
        }

        return $this->redirectToRoute('planning_index');
    }

    /**
     * Creates a form to delete a planning entity.
     *
     * @param Planning $planning The planning entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Planning $planning)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planning_delete', array('id' => $planning->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
