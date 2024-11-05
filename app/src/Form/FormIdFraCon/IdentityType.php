<?php

namespace App\Form\FormIdFraCon;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class IdentityType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('lastName', TextType::class, [
        'label' => 'Nom',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez le nom',
          'class' => 'form-control w-full xl:me-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ]
      ])
      ->add('firstName', TextType::class, [
        'label' => 'Prénom',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez le prénom',
          'class' => 'form-control w-full xl:ms-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
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
          'class' => 'form-control w-full xl:me-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ]
      ])
      ->add('birthPlace', TextType::class, [
        'label' => 'Lieu de naissance',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez son lieu de naissance',
          'class' => 'form-control w-full xl:ms-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ]
      ])
      ->add('address1', TextType::class, [
        'label' => 'Adresse',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez son addresse',
          'class' => 'form-control w-full xl:me-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ]
      ])
      ->add('address2', TextType::class, [
        'label' => 'Adresse +',
        'required' => false,
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => '(optionelle)',
          'class' => 'form-control w-full xl:ms-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ]
      ])
      ->add('cp', IntegerType::class, [
        'label' => 'Code postal',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez son code postal',
          'class' => 'form-control w-full xl:me-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ]
      ])
      ->add('city', TextType::class, [
        'label' => 'Ville',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez sa ville',
          'class' => 'form-control w-full xl:ms-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ]
      ])
      ->add('country', TextType::class, [
        'label' => 'Pays',
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'attr' => [
          'placeholder' => 'Indiquez son pays',
          'class' => 'form-control w-full me-2'
        ],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ]
      ])
      ->add('submit', SubmitType::class, [
        'label' => 'Valider',
        'row_attr' => [
          'class' => 'flex justify-center'
        ],
        'attr' => [
          'class' => 'submit-modal btn btn-primary my-5'
        ]
      ]);;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'use_as_benef' => false,
    ]);
  }
}
