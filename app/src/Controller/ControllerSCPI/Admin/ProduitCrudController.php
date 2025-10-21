<?php

namespace App\Controller\ControllerSCPI\Admin;

use App\Entity\EntitySCPI\Produit;
use App\Form\RepartGeoType;
use App\Form\PerformanceType;
use App\Form\RepartSectorType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
            DateField::new('createdAt', 'Date de création')
                ->hideOnIndex()
                ->setColumns(2),
            DateTimeField::new('updatedAt', 'Date de Màj')
                ->onlyOnDetail()
                ->hideOnForm(),

            FormField::addPanel('Identitée')->collapsible(),
            BooleanField::new('isPromo', 'En Promotion')
                ->setColumns(2),

            FormField::addPanel('Promotion', 'name'),
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
                ->setColumns(11),
            AssociationField::new('categorie', 'Catégorie')
                ->setColumns(11),
            TextField::new('capital', 'Captital')
                ->setColumns(11),
            TextField::new('thematique', 'Thématique')
                ->hideOnIndex()
                ->setColumns(11),
            NumberField::new('capitalisation', 'Capitalisation en Mds €')
                ->hideOnIndex()
                ->setColumns(11),
            IntegerField::new('nbAssoc', 'Nombre d\'associés')
                ->hideOnIndex()
                ->setColumns(11),
            CollectionField::new('performances', 'Performances')
                ->setEntryType(PerformanceType::class)
                ->setFormTypeOption('by_reference', false)
                ->setTemplatePath('/bundles/EasyAdminBundle/custom/performance.html.twig')
                ->onlyOnForms()
                ->renderExpanded()
                ->setColumns(12),
            CollectionField::new('performances', 'Performances')
                // ->setTemplatePath('/bundles/EasyAdminBundle/custom/performance.html.twig')
                ->hideOnIndex()
                ->onlyOnDetail()
                ->setColumns(12),

            //CHIFFRES CLES
            FormField::addPanel('CHIFFRES CLES')->collapsible(),
            MoneyField::new('sharePrice', 'Prix de la part en cts')
                ->setCurrency('EUR')
                ->hideOnIndex()
                ->setColumns(11),
            NumberField::new('shareNbr', 'Nombre de parts')
                ->hideOnIndex()
                ->setColumns(11),
            NumberField::new('shareSubMin', 'Minimum de parts à souscrire')
                ->hideOnIndex()
                ->setColumns(11),
            TextField::new('fruitionDelay', 'Délai de jouissance')
                ->hideOnIndex()
                ->setColumns(11),
            MoneyField::new('withdrawalValue', 'Valeur de retrait en cts')
                ->setCurrency('EUR')
                ->hideOnIndex()
                ->setColumns(11),
            NumberField::new('immvableNbr', 'Nombre d\'immeubles')
                ->hideOnIndex()
                ->setColumns(11),
            NumberField::new('surface', 'Surface gérée en m²')
                ->hideOnIndex()
                ->setColumns(11),
            NumberField::new('tenantNbr', 'Nombre de locataires')
                ->hideOnIndex()
                ->setColumns(11),
            NumberField::new('top', 'TOP en %')
                ->hideOnIndex()
                ->setColumns(11),
            NumberField::new('tof', 'TOF en %')
                ->hideOnIndex()
                ->setColumns(11),
            BooleanField::new('lifeInsuranceAvaible', 'Disponibilité en assurance-vie')
                ->hideOnIndex()
                ->setColumns(11),
            TextField::new('reserveRan', 'Réserves et RAN')
                ->hideOnIndex()
                ->setColumns(11),
            MoneyField::new('worksAdvance', 'Provisions pour travaux en cts')
                ->setCurrency('EUR')
                ->hideOnIndex()
                ->setColumns(11),

            //STRATEGIE
            FormField::addPanel('STRATEGIE')->collapsible(),
            TextEditorField::new('investStrat', 'Stratégie d\'investissement')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),

            CollectionField::new('repartSectors', 'Répartition sectorielle')
                ->setEntryType(RepartSectorType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms()
                ->renderExpanded()
                ->setColumns(12),
            CollectionField::new('repartSectors', 'Répartition sectorielle')
                ->hideOnIndex()
                ->onlyOnDetail()
                ->setColumns(12),

            CollectionField::new('repartGeos', 'Répartition géographique')
                ->setEntryType(RepartGeoType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms()
                ->renderExpanded()
                ->setColumns(12),
            CollectionField::new('repartGeos', 'Répartition géographique')
                ->hideOnIndex()
                ->onlyOnDetail()
                ->setColumns(12),

            TextEditorField::new('infoTrim', 'Informations pertinentes du trimestre')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),
            TextEditorField::new('lifeAssetTrim', 'Vie des actifs au cours du trimestre')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),

            //FRAIS
            FormField::addPanel('FRAIS')->collapsible(),
            TextEditorField::new('subscriptionCom', 'Commission de souscription')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),
            TextEditorField::new('ManageCom', 'Commission de gestion')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),
            TextEditorField::new('arbMovCom', 'Commission d\'arbitrage ou de mouvement')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),
            TextEditorField::new('pilotWorksCom', 'Commission de suivi de pilotage des travaux')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),
            TextEditorField::new('witCessionCom', 'Commission de retrait/cession sur le marché secondaire')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),
            TextEditorField::new('shareMutaCom', 'Commission de cession ou de mutation des parts')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex()
                ->setColumns(12),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->overrideTemplate('crud/new', '/bundles/EasyAdminBundle/custom/produit_new.html.twig')
            ->overrideTemplate('crud/edit', '/bundles/EasyAdminBundle/custom/produit_edit.html.twig')
            ->setDefaultSort(['id' => 'DESC'])
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(10)
            ->renderContentMaximized()
            // ->overrideTemplates([
            //     'crud/field/collection' => '/bundles/EasyAdminBundle/custom/performance.html.twig',
            // ])
        ;
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
