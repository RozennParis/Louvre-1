<?php

namespace P4\LouvreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,[
                'label'=> 'Nom'
            ])
            ->add('lastName', TextType::class,[
                'label'=> 'Prénom'
            ])
            ->add('country', TextType::class,[
                'label'=>'Pays'
            ])
            ->add('birthDate' , DateType::class,[
                'label'=> 'Date de naissance'
            ])
            ->add('reducedPrice' , CheckboxType::class,[
                'label'=> 'Tarif réduit'
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P4\LouvreBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'p4_louvrebundle_ticket';
    }


}
