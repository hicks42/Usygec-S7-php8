<?php

namespace App\Form\FormEZR;

use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class TargetType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', EmailType::class, [
        'attr' => [
          'placeholder' => 'E-mail ciblé',
          'class' => 'form-control mt-5 w-full'
        ]
      ])
      // ->add('envoyer', SubmitType::class, [
      //     'row_attr' => ['class' => 'flex justify-center'],
      //     'attr' => [
      //         'class' => 'btn-primary btn-sm btn-block w-25 my-5'
      //     ]
      // ])
      ->add('captcha', Recaptcha3Type::class, [
        'constraints' => new Recaptcha3(),
        'action_name' => 'contact'
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      // Configure your form options here
    ]);
  }
}
