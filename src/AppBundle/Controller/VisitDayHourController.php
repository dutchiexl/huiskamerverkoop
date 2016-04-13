<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VisitDayHour;
use AppBundle\Form\VisitDayHourType;

/**
 * VisitDayHour controller.
 *
 * @Route("/visitdayhour")
 */
class VisitDayHourController extends Controller
{
    /**
     * Lists all VisitDayHour entities.
     *
     * @Route("/", name="visitdayhour_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $visitDayHours = $em->getRepository('AppBundle:VisitDayHour')->findAll();

        return $this->render('visitdayhour/index.html.twig', array(
            'visitDayHours' => $visitDayHours,
        ));
    }

    /**
     * Creates a new VisitDayHour entity.
     *
     * @Route("/new", name="visitdayhour_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $visitDayHour = new VisitDayHour();
        $form = $this->createForm('AppBundle\Form\VisitDayHourType', $visitDayHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visitDayHour);
            $em->flush();

            return $this->redirectToRoute('visitdayhour_show', array('id' => $visitDayHour->getId()));
        }

        return $this->render('visitdayhour/new.html.twig', array(
            'visitDayHour' => $visitDayHour,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a VisitDayHour entity.
     *
     * @Route("/{id}", name="visitdayhour_show")
     * @Method("GET")
     */
    public function showAction(VisitDayHour $visitDayHour)
    {
        $deleteForm = $this->createDeleteForm($visitDayHour);

        return $this->render('visitdayhour/show.html.twig', array(
            'visitDayHour' => $visitDayHour,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing VisitDayHour entity.
     *
     * @Route("/{id}/edit", name="visitdayhour_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VisitDayHour $visitDayHour)
    {
        $deleteForm = $this->createDeleteForm($visitDayHour);
        $editForm = $this->createForm('AppBundle\Form\VisitDayHourType', $visitDayHour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visitDayHour);
            $em->flush();

            return $this->redirectToRoute('visitdayhour_edit', array('id' => $visitDayHour->getId()));
        }

        return $this->render('visitdayhour/edit.html.twig', array(
            'visitDayHour' => $visitDayHour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a VisitDayHour entity.
     *
     * @Route("/{id}", name="visitdayhour_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VisitDayHour $visitDayHour)
    {
        $form = $this->createDeleteForm($visitDayHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visitDayHour);
            $em->flush();
        }

        return $this->redirectToRoute('visitdayhour_index');
    }

    /**
     * Creates a form to delete a VisitDayHour entity.
     *
     * @param VisitDayHour $visitDayHour The VisitDayHour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VisitDayHour $visitDayHour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visitdayhour_delete', array('id' => $visitDayHour->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
