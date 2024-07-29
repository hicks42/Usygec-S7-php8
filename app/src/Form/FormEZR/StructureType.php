<?php

namespace App\Form\FormEZR;

use App\Entity\EntityEZR\Structure;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'label_attr' => ['class' => 'text-gray-300 mt-1'],
                'attr' => [
                    'placeholder' => 'Nom de l\'établissement',
                    'class' => 'form-control w-full'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de l\'établissement',
                'required' => false,
                'download_uri' => false,
                'imagine_pattern' => 'company_image_banner',
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => [
                    'placeholder' => 'Image au format jpg ou png',
                    'class' => 'form-control text-gray-300 w-full'
                ],
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image',
            ])
            // ->add('googlUrl', TextareaType::class, [
            //     'label' => 'Indiquez l\'URL pour un avis positif (Google) :'
            // ])
            ->add('Pid', TextType::class, [
                'required' => false,
                // 'mapped' => false,
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => ['class' => 'form-control w-full'],
            ])
            ->add('badRevUrl', TextareaType::class, [
                'label' => 'Indiquez l\'URL pour un avis negatif :',
                'required' => false,
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => [
                    'placeholder' => '(optionelle)',
                    'class' => 'form-control w-full'
                ]
            ])
            ->add('adresse1', TextType::class, [
                'label' => 'Adresse 1',
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => [
                    'placeholder' => 'Indiquez l\'addresse',
                    'class' => 'form-control'
                ]
            ])
            ->add('adresse2', TextType::class, [
                'label' => 'Adresse 2',
                'required' => false,
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => [
                    'placeholder' => '(optionelle)',
                    'class' => 'form-control'
                ]
            ])
            ->add('cp', IntegerType::class, [
                'label' => 'Code postal',
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => [
                    'placeholder' => 'Indiquez le code postal',
                    'class' => 'form-control'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => [
                    'placeholder' => 'Indiquez la ville',
                    'class' => 'form-control'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => [
                    'placeholder' => 'Indiquez le pays',
                    'class' => 'form-control'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'text-gray-300 mt-4'],
                'attr' => [
                    'placeholder' => 'Le téléphone du contact',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
