<?php

namespace App\Form;

use App\Entity\Computer;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class ComputerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('processor', TextType::class, [
                'label' => 'Processeur',
                'attr' => ['class' => 'form-control']
            ])
            ->add('memory', TextType::class, [
                'label' => 'Mémoire',
                'attr' => ['class' => 'form-control']
            ])
            ->add('os', TextType::class, [
                'label' => 'Système d\'exploitation',
                'attr' => ['class' => 'form-control']
            ])
            ->add('installedGames', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Jeux installés',
                'attr' => ['class' => 'form-control']
            ])
            ->add('purchaseDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'achat',
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'btn btn-success mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Computer::class,
        ]);
    }
}
