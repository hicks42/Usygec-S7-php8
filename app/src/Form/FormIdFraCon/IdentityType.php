<?php

namespace App\Form\FormIdFraCon;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

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
      ->add('birthDate', DateType::class, [
        'label' => 'Date de naissance',
        'widget' => 'single_text',
        'format' => 'dd/MM/yyyy',
        'html5' => false,
        'label_attr' => ['class' => 'text-gray-500 mt-4'],
        'row_attr' => [
          'class' => 'form-row w-full xl:w-1/2'
        ],
        'attr' => [
          'placeholder' => 'jj/mm/aaaa',
          'class' => 'form-control w-full'
        ],
        'constraints' => [
          new Regex([
            'pattern' => '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(\d{4})$/',
            'message' => 'Veuillez entrer une date valide au format jj/mm/aaaa.',
          ]),
          new LessThanOrEqual([
            'value' => 'today',
            'message' => 'L\'année ne peut pas être supérieure à l\'année en cours.',
          ])
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
      ]);
    // Transformer la date en instance DateTime
    $builder->get('birthDate')->addModelTransformer(new CallbackTransformer(
      function ($dateAsString) {
        // Transforme le string en DateTime
        return $dateAsString ? \DateTime::createFromFormat('d/m/Y', $dateAsString) : null;
      },
      function ($dateAsDateTime) {
        // Transforme l'instance DateTime en string pour le formulaire
        return $dateAsDateTime ? $dateAsDateTime->format('d/m/Y') : null;
      }
    ));
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'use_as_benef' => false,
    ]);
  }
}
