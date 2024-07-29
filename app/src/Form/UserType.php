<?php

namespace App\Form;

use App\Entity\User;
use App\Form\FormEZR\StructureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', TextType::class, [
                'label' => false,
                'label_attr' => [
                    'class' => 'h2',
                ],
                'attr' => [
                    'placeholder' => 'Nom de votre employeur',
                    'class' => 'form-control'
                ]
            ])
            ->add('structures', CollectionType::class, [
                'entry_type' => StructureType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
