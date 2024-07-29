<?php

namespace App\Form\FormBam;

use App\Entity\Customer;
use App\Entity\EntityBam\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ClientType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('activities', CollectionType::class, [
        'entry_type' => ActivityType::class,
        'allow_add' => true,
        'allow_delete' => true,
        'prototype' => true,
        'by_reference' => false,
        //'attr' => ['class' => 'email-box'], // each item
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      // 'data_class' => Company::class,
    ]);
  }
}
