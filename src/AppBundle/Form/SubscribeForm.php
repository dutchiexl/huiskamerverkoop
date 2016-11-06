<?php

namespace AppBundle\Form;

use AppBundle\Repository\VisitDayHourRepository;
use AppBundle\Repository\VisitingDayRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscribeForm extends AbstractType
{
    private $visitingDayRepository;
    private $visitDayHourRepository;

    public function __construct(VisitingDayRepository $visitingDayRepository, VisitDayHourRepository $visitDayHourRepository)
    {
        $this->visitingDayRepository = $visitingDayRepository;
        $this->visitDayHourRepository = $visitDayHourRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Voornaam'
                ]
            ])
            ->add('lastName', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Naam'
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email adres'
                ]
            ])
            ->add('interests', EntityType::class, array(
                'class' => 'AppBundle:Interest',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ))
            ->add('day', EntityType::class, [
                'placeholder' => 'Choose an option',
                'class' => 'AppBundle:VisitingDay',
                'empty_data' => null,
                'mapped' => false,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    $er->findBy(['deleted' => false]);
                },
            ])
            ->add('visit', \AppBundle\Form\Type\EntityHiddenType::class,[
                'class' => 'AppBundle\Entity\VisitDayHour'
            ])
            ->add('save', SubmitType::class, [
                    'label' => 'Inschrijven',
                    'attr' => array('class' => 'btn-medium'),
                    'translation_domain' => 'question'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Subscriber',
        ));
    }

    public function getName()
    {
        return 'app_bundle_subscribe_form';
    }
}
