<?php

namespace App\Controller\ControllerSCPI\Admin;

use App\Entity\EntitySCPI\Produit;
use App\Form\FormSCPI\RepartGeoType;
use App\Form\FormSCPI\PerformanceType;
use App\Form\FormSCPI\RepartSectorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Produit::class;
  }

  /**/
  public function configureFields(string $pageName): iterable
  {
    return [
      FormField::addColumn(12),
      DateField::new('createdAt', 'Date de création')
        ->hideOnIndex()
        ->setColumns(2),
      BooleanField::new('isPromo', 'En Promotion')
        ->setColumns(10),
      DateTimeField::new('updatedAt', 'Date de Màj')
        ->onlyOnDetail()
        ->hideOnForm(),

      FormField::addRow(),
      FormField::addColumn(6),
      FormField::addPanel('Identitée')->setIcon('fa fa-id-card')->collapsible()->renderCollapsed(),
      TextField::new('name', 'Nom du produit')
        ->setColumns(12),
      SlugField::new('slug')
        ->setTargetFieldName('name')
        ->onlyOnForms()
        ->setColumns(12),
      ImageField::new('imageName', 'Logo')
        ->setBasePath('images/produits')
        ->setUploadDir('public/images/produits')
        ->setRequired(false)
        ->setUploadedFileNamePattern('[randomhash].[extension]')
        ->setColumns(12),
      TextField::new('socGest', 'Société de gestion')
        ->setColumns(12),
      AssociationField::new('categorie', 'Catégorie')
        ->setColumns(12),
      TextField::new('capital', 'Captital')
        ->setColumns(12),
      TextField::new('thematique', 'Thématique')
        ->hideOnIndex()
        ->setColumns(12),
      NumberField::new('capitalisation', 'Capitalisation en Mds €')
        ->hideOnIndex()
        ->setColumns(12),
      IntegerField::new('nbAssoc', 'Nombre d\'associés')
        ->hideOnIndex()
        ->setColumns(12),

      FormField::addColumn(6),
      FormField::addPanel('Performances')->setIcon('fa fa-chart-line')->collapsible()->renderCollapsed(),
      CollectionField::new('performances')
        ->setEntryType(PerformanceType::class)
        ->setFormTypeOption('by_reference', false)
        ->onlyOnForms()
        ->allowAdd()
        ->allowDelete()
        ->setColumns(12)
        ->setLabel(false),

      CollectionField::new('performances', 'Performances')
        ->hideOnIndex()
        ->onlyOnDetail()
        ->setColumns(12),
      FormField::addColumn(),

      //CHIFFRES CLES
      FormField::addColumn(12),
      FormField::addPanel('CHIFFRES CLES')->setIcon('fa fa-calculator')->collapsible()->renderCollapsed(),
      MoneyField::new('sharePrice', 'Prix de la part en cts')
        ->setCurrency('EUR')
        ->hideOnIndex()
        ->setColumns(2),
      NumberField::new('shareNbr', 'Nombre de parts')
        ->hideOnIndex()
        ->setColumns(2),
      NumberField::new('shareSubMin', 'Minimum de parts à souscrire')
        ->hideOnIndex()
        ->setColumns(2),
      TextField::new('fruitionDelay', 'Délai de jouissance')
        ->hideOnIndex()
        ->setColumns(2),
      MoneyField::new('withdrawalValue', 'Valeur de retrait en cts')
        ->setCurrency('EUR')
        ->hideOnIndex()
        ->setColumns(2),
      NumberField::new('immvableNbr', 'Nombre d\'immeubles')
        ->hideOnIndex()
        ->setColumns(2),
      NumberField::new('surface', 'Surface gérée en m²')
        ->hideOnIndex()
        ->setColumns(2),
      NumberField::new('tenantNbr', 'Nombre de locataires')
        ->hideOnIndex()
        ->setColumns(2),
      NumberField::new('top', 'TOP en %')
        ->hideOnIndex()
        ->setColumns(2),
      NumberField::new('tof', 'TOF en %')
        ->hideOnIndex()
        ->setColumns(2),
      TextField::new('reserveRan', 'Réserves et RAN')
        ->hideOnIndex()
        ->setColumns(2),
      MoneyField::new('worksAdvance', 'Provisions pour travaux en cts')
        ->setCurrency('EUR')
        ->hideOnIndex()
        ->setColumns(2),
      BooleanField::new('lifeInsuranceAvaible', 'Disponibilité en assurance-vie')
        ->hideOnIndex()
        ->setColumns(2),
      FormField::addColumn(),

      //STRATEGIE
      FormField::addColumn(12),
      FormField::addPanel('STRATEGIE')->setIcon('fa fa-chess')->collapsible()->renderCollapsed(),
      TextEditorField::new('investStrat', 'Stratégie d\'investissement')
        ->hideOnIndex()
        ->setColumns(12),

      CollectionField::new('repartSectors', 'Répartition sectorielle')
        ->setEntryType(RepartSectorType::class)
        ->setFormTypeOption('by_reference', false)
        ->onlyOnForms()
        ->renderExpanded()
        ->setColumns(12)
        ->addCssClass('repart-grid-2cols'),
      CollectionField::new('repartSectors', 'Répartition sectorielle')
        ->hideOnIndex()
        ->onlyOnDetail()
        ->setColumns(12),

      CollectionField::new('repartGeos', 'Répartition géographique')
        ->setEntryType(RepartGeoType::class)
        ->setFormTypeOption('by_reference', false)
        ->onlyOnForms()
        ->renderExpanded()
        ->setColumns(12)
        ->addCssClass('repart-grid-2cols'),
      CollectionField::new('repartGeos', 'Répartition géographique')
        ->hideOnIndex()
        ->onlyOnDetail()
        ->setColumns(12),

      TextEditorField::new('infoTrim', 'Informations pertinentes du trimestre')
        ->hideOnIndex()
        ->setColumns(6),
      TextEditorField::new('lifeAssetTrim', 'Vie des actifs au cours du trimestre')
        ->hideOnIndex()
        ->setColumns(6),
      FormField::addColumn(),

      //FRAIS
      FormField::addColumn(12),
      FormField::addPanel('FRAIS')->setIcon('fa fa-euro-sign')->collapsible()->renderCollapsed(),
      TextEditorField::new('subscriptionCom', 'Commission de souscription')
        ->hideOnIndex()
        ->setColumns(6),
      TextEditorField::new('ManageCom', 'Commission de gestion')
        ->hideOnIndex()
        ->setColumns(6),
      TextEditorField::new('arbMovCom', 'Commission d\'arbitrage ou de mouvement')
        ->hideOnIndex()
        ->setColumns(6),
      TextEditorField::new('pilotWorksCom', 'Commission de suivi de pilotage des travaux')
        ->hideOnIndex()
        ->setColumns(6),
      TextEditorField::new('witCessionCom', 'Commission de retrait/cession sur le marché secondaire')
        ->hideOnIndex()
        ->setColumns(6),
      TextEditorField::new('shareMutaCom', 'Commission de cession ou de mutation des parts')
        ->hideOnIndex()
        ->setColumns(6),
      FormField::addColumn(),
    ];
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Produit')
      ->setEntityLabelInPlural('Produits')
      ->setDefaultSort(['id' => 'DESC'])
      ->showEntityActionsInlined()
      ->setPaginatorPageSize(10)
      ->renderContentMaximized()
      ->setFormThemes(['scpi/admin/sectorial_form_theme.html.twig'])
      ->setPageTitle('edit', fn(Produit $produit) => sprintf('Modifier <b>%s</b>', $produit->getName()));
  }

  public function configureAssets(Assets $assets): Assets
  {
    return $assets

      ->addJsFile('ea_collection.js')
      ->addCssFile('css/admin.css');
  }

  public function configureActions(Actions $actions): Actions
  {
    return $actions
      ->add(Crud::PAGE_INDEX, Action::DETAIL);
  }
}
