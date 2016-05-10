<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscriber;
use AppBundle\Form\SubscribeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
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

    /**
     * @Route("/debug465416519878432154646", name="debug")
     */
    public function debugAction(Request $request)
    {
        $subscription = $this->getDoctrine()->getRepository('AppBundle:Subscriber')->find(16);
        $logger = $this->get('logger');
        $logger->info('Registration:' . $subscription->getFirstName() . ' heeft zich geregistreerd met het email adres: ' . $subscription->getEmail());
        $message = \Swift_Message::newInstance()
            ->setSubject('Registratie huiskamerverkoop')
            ->setFrom('valeriediels@hotmail.com')
            ->setTo($subscription->getEmail())
            ->setBody(
                $this->renderView(
                    'AppBundle:Emails:registration.html.twig',
                    array('subscription' => $subscription)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
        $message = \Swift_Message::newInstance()
            ->setSubject('Nieuwe registratie huiskamerverkoop')
            ->setFrom('valeriediels@hotmail.com')
            ->setTo('dutchiexl@gmail.com')
            ->setBody(
                $this->renderView(
                    'AppBundle:Emails:registration_notice.html.twig',
                    array('subscription' => $subscription)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
    }

    /**
     * @Route("/showsubscriptions65465423165446513216544", name="showsubscriptions")
     * @Template()
     */
    public function showSubscriptionAction()
    {
        $subscriptions = $this->getDoctrine()->getRepository('AppBundle:Subscriber')->findAll();
        $visitDays = $this->getDoctrine()->getRepository('AppBundle:VisitingDay')->findBy([], ['day' => 'ASC']);
        return [
            'subscriptions' => $subscriptions,
            'days' => $visitDays
        ];
    }
}
