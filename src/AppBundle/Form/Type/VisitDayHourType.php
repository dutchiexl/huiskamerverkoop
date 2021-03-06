<?php


namespace AppBundle\Form\Type;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VisitDayHourType
 * @package AppBundle\Form\Type
 */
class VisitDayHourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('visit', EntityType::class, [
            'placeholder' => 'Choose an option',
            'class' => 'AppBundle:VisitDayHour',
            'empty_data' => null,
            'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VisitDayHour',
        ));

    }
}
