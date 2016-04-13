<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VisitingDay;
use AppBundle\Form\VisitingDayType;

/**
 * VisitingDay controller.
 *
 * @Route("/visitingday")
 */
class VisitingDayController extends Controller
{
    /**
     * Lists all VisitingDay entities.
     *
     * @Route("/", name="visitingday_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $visitingDays = $em->getRepository('AppBundle:VisitingDay')->findAll();

        return $this->render('visitingday/index.html.twig', array(
            'visitingDays' => $visitingDays,
        ));
    }

    /**
     * Creates a new VisitingDay entity.
     *
     * @Route("/new", name="visitingday_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $visitingDay = new VisitingDay();
        $form = $this->createForm('AppBundle\Form\VisitingDayType', $visitingDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visitingDay);
            $em->flush();

            return $this->redirectToRoute('visitingday_show', array('id' => $visitingDay->getId()));
        }

        return $this->render('visitingday/new.html.twig', array(
            'visitingDay' => $visitingDay,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a VisitingDay entity.
     *
     * @Route("/{id}", name="visitingday_show")
     * @Method("GET")
     */
    public function showAction(VisitingDay $visitingDay)
    {
        $deleteForm = $this->createDeleteForm($visitingDay);

        return $this->render('visitingday/show.html.twig', array(
            'visitingDay' => $visitingDay,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing VisitingDay entity.
     *
     * @Route("/{id}/edit", name="visitingday_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VisitingDay $visitingDay)
    {
        $deleteForm = $this->createDeleteForm($visitingDay);
        $editForm = $this->createForm('AppBundle\Form\VisitingDayType', $visitingDay);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visitingDay);
            $em->flush();

            return $this->redirectToRoute('visitingday_edit', array('id' => $visitingDay->getId()));
        }

        return $this->render('visitingday/edit.html.twig', array(
            'visitingDay' => $visitingDay,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a VisitingDay entity.
     *
     * @Route("/{id}", name="visitingday_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VisitingDay $visitingDay)
    {
        $form = $this->createDeleteForm($visitingDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visitingDay);
            $em->flush();
        }

        return $this->redirectToRoute('visitingday_index');
    }

    /**
     * Creates a form to delete a VisitingDay entity.
     *
     * @param VisitingDay $visitingDay The VisitingDay entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VisitingDay $visitingDay)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visitingday_delete', array('id' => $visitingDay->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
