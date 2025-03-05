<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Computer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('computer', EntityType::class, [
                'class' => Computer::class,
                'choice_label' => 'name',
                'label' => 'Ordinateur',
                'attr' => ['class' => 'form-control']
            ])
            ->add('startTime', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure de début',
                'attr' => [
                    'class' => 'form-control',
                    'step' => 1800 // 1800 seconds = 30 minutes
                ]
            ])
            ->add('duration', ChoiceType::class, [
                'choices' => [
                    '1 heure' => 1,
                    '2 heures' => 2,
                    '3 heures' => 3,
                    '4 heures' => 4,
                    '5 heures' => 5,
                ],
                'label' => 'Durée',
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Réserver',
                'attr' => ['class' => 'btn btn-success mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
