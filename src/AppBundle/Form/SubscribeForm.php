<?php

namespace AppBundle\Form;

use AppBundle\Repository\VisitDayHourRepository;
use AppBundle\Repository\VisitingDayRepository;
use Doctrine\ORM\EntityRepository;
use Glifery\EntityHiddenTypeBundle\Form\Type\EntityHiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $builder->add('firstName')
            ->add('lastName')
            ->add('email')
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
                    $er->findAll();
                },
            ])
            ->add('visit', EntityHiddenType::class,[
                'class' => 'AppBundle\Entity\VisitDayHour'
            ])
            ->add('save', SubmitType::class, [
                    'label' => 'submit',
                    'attr' => array('class' => 'btn btn-primary'),
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
