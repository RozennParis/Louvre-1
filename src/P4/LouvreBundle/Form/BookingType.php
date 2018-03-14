<?php
namespace P4\LouvreBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('visitDate', DateType::class,[
                'label'=> 'Date de la visite',
                'widget'=>'single_text',

            ])
            ->add('ticketsNumber', ChoiceType::class, [
                'label'=>'Nombre de billets',
                'choices'=>[
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
                ]
            ])
            ->add('ticketsType', ChoiceType::class,[
                'label'=>'Type de billet',
                'choices' =>[
                    'Journée' => 'Journée',
                    'Demi-journée'=>'Demi-journée',
                ]
            ])
            ->add('email', EmailType::class, [
                'label'=>'Adresse email'
            ])
            ->add('save', SubmitType::class,[
                'label'=>'Valider'
            ]);
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
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'p4_louvrebundle_booking';
    }
}