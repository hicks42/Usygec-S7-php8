<?php

namespace App\Form\FormIdFraCon;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BeneficiaireType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('lastName', TextType::class, [
        'label' => 'Nom du bénéficiare',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez le nom',
          'class' => 'form-control'
        ]
      ])
      ->add('firstName', TextType::class, [
        'label' => 'Prénom',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez le prénom',
          'class' => 'form-control'
        ]
      ])
      ->add('birthDate', TextType::class, [
        'label' => 'Date de naissance',
        // 'widget' => 'single_text',
        // 'format' => 'yyyy-MM-dd',
        // 'html5' => false,
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez sa date de naissance',
          'class' => 'form-control'
        ]
      ])
      ->add('birthPlace', TextType::class, [
        'label' => 'Lieu de naissance',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez son lieu de naissance',
          'class' => 'form-control'
        ]
      ])
      ->add('address1', TextType::class, [
        'label' => 'Adresse du bénéficiaire',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez son addresse',
          'class' => 'form-control'
        ]
      ])
      ->add('address2', TextType::class, [
        'label' => 'Adresse +',
        'required' => false,
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => '(optionelle)',
          'class' => 'form-control'
        ]
      ])
      ->add('cp', IntegerType::class, [
        'label' => 'Code postal',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez son code postal',
          'class' => 'form-control'
        ]
      ])
      ->add('city', TextType::class, [
        'label' => 'Ville',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez sa ville',
          'class' => 'form-control'
        ]
      ])
      ->add('country', TextType::class, [
        'label' => 'Pays',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez son pays',
          'class' => 'form-control'
        ]
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      // Configure your form options here
    ]);
  }
}
