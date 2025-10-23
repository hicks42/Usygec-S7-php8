<?php

namespace App\Form\FormSCPI;

use App\Entity\EntitySCPI\RepartSector;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepartSectorType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('sectorName', TextType::class, [
        'label' => 'Nom du secteur',
        'row_attr' => [
          'class' => 'inline'
        ],
        'attr' => [
          'class' => 'repart-input'
        ]
      ])
      ->add('sectorValue', NumberType::class, [
        'label' => 'Valeur en %',
        'row_attr' => [
          'class' => 'inline'
        ],
        'attr' => [
          'class' => 'repart-input'
        ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => RepartSector::class,
    ]);
  }
}
