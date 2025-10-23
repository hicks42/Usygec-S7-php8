<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class UserEditType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder

      ->add('roles', ChoiceType::class, [
        'label' => 'Rôles',
        'choices' => [
          'Administrateur' => 'ROLE_ADMIN',
          'Utilisateur idfracon' => 'ROLE_IDFRACON',
          'Utilisateur Bam' => 'ROLE_BAM',
          'Utilisateur EZreview' => 'ROLE_EZR',
          'Utilisateur SCPI' => 'ROLE_SCPI',
        ],
        'multiple' => true,
        'expanded' => true,
      ])
      ->add('email', EmailType::class, [
        'label' => 'Email',
        'row_attr' => [
          'class' => 'mt-3'
        ],
        'attr' => [
          'placeholder' => 'ex: John.doe@company.com',
          'class' => 'form-control'
        ]
      ])
      ->add('plainPassword', RepeatedType::class, [
        'required' => false,
        'type' => PasswordType::class,
        'options' => [
          'attr' => [
            'autocomplete' => 'new-password',
            'class' => 'form-control'
          ],
        ],
        'first_options'  => [
          'label' => 'Password',
          'hash_property_path' => 'password'
        ],
        'second_options' => [
          'label' => 'Repeat Password'
        ],
        'mapped' => false,
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
