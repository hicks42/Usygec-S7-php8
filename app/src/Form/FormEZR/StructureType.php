<?php

namespace App\Form\FormEZR;

use App\Entity\EntityEZR\Structure;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StructureType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      // ÉTAPE 1 : Informations essentielles pour trouver le PID
      ->add('name', TextType::class, [
        'label' => 'Nom de l\'établissement',
        'label_attr' => ['class' => 'text-gray-700 font-semibold mt-1'],
        'attr' => [
          'placeholder' => 'Ex: Restaurant Le Bistrot',
          'class' => 'form-control w-full'
        ]
      ])
      ->add('cp', IntegerType::class, [
        'label' => 'Code postal',
        'label_attr' => ['class' => 'text-gray-700 font-semibold mt-4'],
        'attr' => [
          'placeholder' => 'Ex: 42000',
          'class' => 'form-control w-full'
        ]
      ])

      // Place ID (sera pré-rempli automatiquement)
      ->add('Pid', TextType::class, [
        'required' => false,
        'label' => 'Place ID Google',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'class' => 'form-control w-full bg-gray-100',
          'placeholder' => 'ChIJ...',
          'readonly' => true
        ],
        'help' => 'Généré automatiquement via le bouton "Créer le lien"',
        'help_attr' => ['class' => 'text-gray-400 text-sm']
      ])

      // ÉTAPE 2 : Reste du formulaire (débloqué après avoir le PID)
      ->add('imageFile', VichImageType::class, [
        'label' => 'Image de l\'établissement',
        'required' => false,
        'download_uri' => false,
        'imagine_pattern' => 'company_image_banner',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Image au format jpg ou png',
          'class' => 'form-control text-gray-500 w-full'
        ],
        'allow_delete' => true,
        'delete_label' => 'Supprimer l\'image',
      ])
      ->add('adresse1', TextType::class, [
        'label' => 'Adresse 1',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez l\'adresse',
          'class' => 'form-control w-full'
        ]
      ])
      ->add('adresse2', TextType::class, [
        'label' => 'Adresse 2',
        'required' => false,
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => '(optionnelle)',
          'class' => 'form-control w-full'
        ]
      ])
      ->add('city', TextType::class, [
        'label' => 'Ville',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez la ville',
          'class' => 'form-control w-full'
        ]
      ])
      ->add('country', TextType::class, [
        'label' => 'Pays',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez le pays',
          'class' => 'form-control w-full'
        ]
      ])
      ->add('phone', TelType::class, [
        'label' => 'Téléphone',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Le téléphone du contact',
          'class' => 'form-control w-full'
        ]
      ])
      ->add('badRevUrl', TextareaType::class, [
        'label' => 'Indiquez l\'URL pour un avis négatif :',
        'required' => false,
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => '(optionnelle)',
          'class' => 'form-control w-full'
        ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Structure::class,
    ]);
  }
}
