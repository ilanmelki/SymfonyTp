<?php

namespace ReservationBundle\Form;

use Doctrine\DBAL\Types\TextType;
use ReservationBundle\Entity\Promo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date',DateType::class, ['label' => 'choisissez une date'])
                ->add('horaire',ChoiceType::class, [
                                                                'choices'  => [
                                                                    '09:00-12:30' => true,
                                                                    '13:30-17:00' => false
                                                                ]])
                ->add('promo')
                ->add('formateur')
                ->add('salle');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReservationBundle\Entity\Reservation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reservationbundle_reservation';
    }


}
