<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscriber;
use AppBundle\Form\SubscribeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Subscribe controller.
 *
 * @Route("/subscribe")
 */
class SubscribeController extends Controller
{
    /**
     * Creates a new VisitDayHour entity.
     *
     * @Route("/subscribe", name="subscriber_new")
     * @Method({ "POST"})
     */
    public function newAction(Request $request)
    {
        $subscription = new Subscriber();
        $form = $this->createForm(SubscribeForm::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscription);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('visitdayhour/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
