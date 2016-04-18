<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscriber;
use AppBundle\Form\SubscribeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $subscribeForm = $this->createForm(SubscribeForm::class, new Subscriber(), ['action' => $this->generateUrl('subscriber_new')]);
        $days = $this->getDoctrine()->getRepository('AppBundle:VisitingDay')->findAll();
        // replace this example code with whatever you need
        return [
            'days' => $days,
            'subscribeForm' => $subscribeForm->createView()
        ];
    }
}
