<?php

namespace P4\LouvreBundle\Form;

use P4\LouvreBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class TicketType
 * @package P4\LouvreBundle\Form
 */
class TicketType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName',TextType::class,array(
                'label' => 'last name'
            ))
            ->add('firstName',TextType::class,array(
                'label' => 'first name'
            ))
            ->add('country', CountryType::class,array(
                'label' => 'country',
                'preferred_choices' => array('FR')
            ))
            ->add('birthDate',DateType::class,array(
                'years' => range(date('Y'),date('Y')-120),
                'label' => 'birth date',
                'format' => 'dd/MM/yyyy',
                'placeholder' => array(
                    'year' => 'year', 'month' => 'month', 'day' => 'day'
                ),
                ))

            ->add('reducedPrice',CheckboxType::class,array(
                'label' => 'reduced price',
                'required'=>false,
    ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class,
            'validation_groups' => array('Ticket'),
        ));
    }

}
