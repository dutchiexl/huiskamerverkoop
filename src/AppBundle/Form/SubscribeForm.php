<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscribeForm extends AbstractType
{
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
            ->add('visit', EntityType::class, array(
                'class' => 'AppBundle:VisitDayHour',
                'choice_label' => 'time',
            ))
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
