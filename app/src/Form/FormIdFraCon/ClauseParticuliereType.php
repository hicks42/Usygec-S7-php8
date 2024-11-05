<?php

namespace App\Form\FormIdFraCon;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClauseParticuliereType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('clauseText', TextareaType::class, [
        'label' => false,
        'attr' => [
          'class' => 'form-control h-32 w-full'
        ],
        'row_attr' => [
          'class' => 'form-row w-full'
        ]
      ])->add('submit', SubmitType::class, [
        'label' => 'Confirmer',
        'attr' => [
          'class' => 'submit-modal btn btn-primary'
        ],
        'row_attr' => [
          'class' => 'flex justify-center w-full'
        ]
      ]);
  }
}
