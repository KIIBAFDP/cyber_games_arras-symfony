<?php

namespace App\Form;

use App\Entity\Maintenance;
use App\Entity\Computer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceType extends AbstractType
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
            ->add('maintenanceDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de maintenance',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control']
            ])
            ->add('isCompleted', CheckboxType::class, [
                'label' => 'Maintenance terminée',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Planifier',
                'attr' => ['class' => 'btn btn-success mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maintenance::class,
        ]);
    }
}
