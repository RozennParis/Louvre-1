<?php

namespace P4\LouvreBundle\Form;

use P4\LouvreBundle\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BookingType
 * @package P4\LouvreBundle\Form
 */
class BookingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate', DateType::class, array(
                'html5' => 'true',
                'label' => 'visit date',
                'widget' => 'single_text',
            ))
            ->add('ticketType', ChoiceType::class, array(
                'choices' => array(
                    'day' => Booking::BOOKING_FULL_DAY,
                    'half-day' => Booking::BOOKING_HALF_DAY,
                ),
                'expanded'=> Booking::BOOKING_FULL_DAY,
                'label' => 'ticket type'

            ))
            ->add('nbTickets', ChoiceType::class, array(
                'label' => 'tickets(s) quantity',
                'choices' => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10
                )
            ))
            ->add('email', RepeatedType::class, array(
                'type' => EmailType::class,
                'required' => true,
                'first_options' => array('label' => 'email'),
                'second_options' => array('label' => 'email confirmation')
            ));
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Booking::class
        ));
    }


}
