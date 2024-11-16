<?php

namespace App\Form\FormIdFraCon;

use App\Entity\EntityIdFraCon\Clauses;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClausesType extends AbstractType
{
  private Security $security;

  public function __construct(Security $security)
  {
    $this->security = $security;
  }

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', TextType::class, [
        'label' => 'Nom de la clause:',
        'row_attr' => [
          'class' => 'my-5'
        ],
        'attr' => [
          'class' => 'form-control w-full'
        ]
      ])
      ->add('description', TextareaType::class, [
        'label' => 'Description:',
        'row_attr' => [
          'class' => 'my-5'
        ],
        'attr' => [
          'class' => 'form-control w-full h-32'
        ]
      ]);

    if ($this->security->isGranted('ROLE_ADMIN')) {
      $builder->add('modal', TextType::class, [
        'label' => 'Nom de la modal (optionnel):',
        'required' => false,
        'row_attr' => [
          'class' => 'my-5'
        ],
        'attr' => [
          'class' => 'form-control w-full'
        ]
      ]);
    }
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Clauses::class,
    ]);
  }
}
