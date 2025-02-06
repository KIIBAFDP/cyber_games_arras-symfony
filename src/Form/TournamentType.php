<?php

namespace App\Form;

use App\Entity\Tournament;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'title',
                'label' => 'Jeu',
                'attr' => ['class' => 'form-control']
            ])
            ->add('maxParticipants', IntegerType::class, [
                'label' => 'Nombre maximum de participants',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournament::class,
        ]);
    }
}
