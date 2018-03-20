<?php

namespace P4\LouvreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate',DateType::class,array(
                'widget'=>'single_text',
                'html5'=>'false',
                'attr'=>array('class'=>'js-datepicker'),
            ))
            ->add('ticketType',ChoiceType::class,array(
                'choices'=>array(
                    'Journée' =>'Journée',
                    'Demi-journée' =>'Demi-journée',
                )
            ))
            ->add('nbTickets',ChoiceType::class,array(
                'choices'=>array(
                    '1'=>1,
                    '2'=>2,
                    '3'=>3,
                    '4'=>4,
                    '5'=>5,
                    '6'=>6,
                    '7'=>7,
                    '8'=>8,
                    '9'=>9,
                    '10'=>10
                )
            ))
            ->add('email',EmailType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P4\LouvreBundle\Entity\Booking'
        ));
    }


}
