<?php

namespace App\Form\FormIdFraCon;

use App\Entity\EntityIdFraCon\Clauses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClausesType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class, [
        'label' => 'Nom de la clause:',
        'attr' => [
          'class' => 'form-control w-full'
        ]
      ])
      ->add('description', TextareaType::class, [
        'label' => 'Description:',
        'attr' => [
          'class' => 'form-control w-full'
        ]
      ])
      ->add('modal', TextType::class, [
        'label' => 'Nom de la modal (optionnel):',
        'required' => false,
        'attr' => [
          'class' => 'form-control w-full'
        ]
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Clauses::class,
    ]);
  }
}
