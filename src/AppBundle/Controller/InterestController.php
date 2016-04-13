<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Interest;
use AppBundle\Form\InterestType;

/**
 * Interest controller.
 *
 * @Route("/interest")
 */
class InterestController extends Controller
{
    /**
     * Lists all Interest entities.
     *
     * @Route("/", name="interest_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $interests = $em->getRepository('AppBundle:Interest')->findAll();

        return $this->render('interest/index.html.twig', array(
            'interests' => $interests,
        ));
    }

    /**
     * Creates a new Interest entity.
     *
     * @Route("/new", name="interest_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $interest = new Interest();
        $form = $this->createForm('AppBundle\Form\InterestType', $interest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interest);
            $em->flush();

            return $this->redirectToRoute('interest_show', array('id' => $interest->getId()));
        }

        return $this->render('interest/new.html.twig', array(
            'interest' => $interest,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Interest entity.
     *
     * @Route("/{id}", name="interest_show")
     * @Method("GET")
     */
    public function showAction(Interest $interest)
    {
        $deleteForm = $this->createDeleteForm($interest);

        return $this->render('interest/show.html.twig', array(
            'interest' => $interest,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Interest entity.
     *
     * @Route("/{id}/edit", name="interest_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Interest $interest)
    {
        $deleteForm = $this->createDeleteForm($interest);
        $editForm = $this->createForm('AppBundle\Form\InterestType', $interest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interest);
            $em->flush();

            return $this->redirectToRoute('interest_edit', array('id' => $interest->getId()));
        }

        return $this->render('interest/edit.html.twig', array(
            'interest' => $interest,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Interest entity.
     *
     * @Route("/{id}", name="interest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Interest $interest)
    {
        $form = $this->createDeleteForm($interest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($interest);
            $em->flush();
        }

        return $this->redirectToRoute('interest_index');
    }

    /**
     * Creates a form to delete a Interest entity.
     *
     * @param Interest $interest The Interest entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Interest $interest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('interest_delete', array('id' => $interest->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
