<?php

namespace App\Form\FormBam;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CsvType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('csvFile', FileType::class, [
        'label' => 'Fichier CSV ',
        'mapped' => false,
        'required' => true,
        'attr' => [
          'accept' => '.csv'
        ],
        'constraints' => [
          new File([
            'maxSize' => '8M',
            'mimeTypes' => [
              'text/csv',
              'text/plain',
              'application/csv',
              'text/comma-separated-values',
              'application/vnd.ms-excel',
            ],
            'mimeTypesMessage' => 'Merci d\'indiquer un fichier CSV valide',
          ])
        ],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      // Configure your form options here
    ]);
  }

  public function getBlockPrefix(): string
  {
    return 'csv';
  }
}
