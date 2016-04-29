<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscriber;
use AppBundle\Form\SubscribeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     * @Template("AppBundle:default:index.html.twig")
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
            $this->addFlash(
                'notice',
                'Proficiat! u bent ingeschreven. U krijgt zo meteen een bevestigingsmail van ons.'
            );
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
            return $this->redirectToRoute('homepage');
        }

        $days = $this->getDoctrine()->getRepository('AppBundle:VisitingDay')->findAll();
        // replace this example code with whatever you need
        return [
            'days' => $days,
            'subscribeForm' => $form->createView()
        ];
    }
}
