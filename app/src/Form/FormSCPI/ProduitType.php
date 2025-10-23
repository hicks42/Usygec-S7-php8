<?php

namespace App\Form\FormSCPI;

use App\Entity\EntitySCPI\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name')
      ->add('soc_gest')
      ->add('capital')
      ->add('thematique')
      ->add('capitalisation')
      ->add('nb_assoc')
      ->add('imageName')
      ->add('slug')
      ->add('isPromo')
      ->add('sharePrice')
      ->add('shareNbr')
      ->add('shareSubMin')
      ->add('fruitionDelay')
      ->add('withdrawalValue')
      ->add('immvableNbr')
      ->add('surface')
      ->add('tenantNbr')
      ->add('top')
      ->add('tof')
      ->add('lifeInsuranceAvaible')
      ->add('reserveRan')
      ->add('worksAdvance')
      ->add('investStrat')
      ->add('infoTrim')
      ->add('lifeAssetTrim')
      ->add('subscriptionCom')
      ->add('ManageCom')
      ->add('arbMovCom')
      ->add('pilotWorksCom')
      ->add('witCessionCom')
      ->add('shareMutaCom')
      ->add('createdAt')
      ->add('updatedAt')
      ->add('categorie');
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Produit::class,
    ]);
  }
}
