<?php

namespace App\Form\FormBam;

use App\Entity\EntityBam\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ActivityType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class, [
        'label' => false,
        'required' => true,
        'attr' => [
          'placeholder' => 'Nom',
          'class' => 'form-control w-full'
        ],
        'row_attr' => [
          'class' => 'my-1'
        ]
      ])
      ->add('description', TextareaType::class, [
        'label' => false,
        'required' => true,
        'attr' => [
          'placeholder' => 'Description',
          'class' => 'form-control w-full mt-1 resize-none overflow-hidden',
          'rows' => 2
        ]
      ])
      ->add('reminder', DateType::class, [
        'label' => 'Rappel : ',
        'required' => false,
        'html5' => false,
        'widget' => 'single_text',
        'format' => 'dd-MM-yyyy',
        'row_attr' => [
          'class' => ''
        ],
        'label_attr' => [
          'class' => 'text-nowrap mb-1',
        ],
        'attr' => [
          'placeholder' => 'jj/mm/aaaa',
          'class' => 'flatpickr form-control w-full',
        ]
      ])
      ->add('dueDate', DateType::class, [
        'label' => 'Limite : ',
        'required' => false,
        'html5' => false,
        'widget' => 'single_text',
        'format' => 'dd-MM-yyyy',
        'row_attr' => [
          'class' => ''
        ],
        'label_attr' => [
          'class' => 'text-nowrap mb-1',
        ],
        'attr' => [
          'placeholder' => 'jj/mm/aaaa',
          'class' => 'flatpickr form-control w-full',
        ]
      ])
      ->add('isActive', CheckboxType::class, [
        'required' => false,
        'label' => 'En cours : ',
        'row_attr' => [
          'class' => 'form-switch float-end me-2'
        ],
        'label_attr' => [
          'class' => 'text-nowrap',
        ],
        'attr' => [
          'class' => 'toggle-switch is-active ms-2',
          'data-toggle' => 'toggle',
          'type' => 'checkbox',
          'role' => 'switch',
        ],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Activity::class,
    ]);
  }
}
