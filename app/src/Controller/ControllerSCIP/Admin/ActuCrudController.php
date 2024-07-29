<?php

namespace App\Controller\ControllerSCIP\Admin;

use App\Entity\EntitySCIP\Actu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('updatedAt')
                ->onlyOnDetail()
                ->hideOnForm(),
            FormField::addPanel('Publié', 'name'),
            BooleanField::new('isOnline', 'En ligne')
                ->setColumns(2),
            FormField::addPanel('Identitée')->collapsible(),
            TextField::new('title', 'Titre')
                ->setColumns(6),
            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->onlyOnForms()
                ->setColumns(6),
            TextEditorField::new('content', 'Contenu')
                // ->setFormType(CKEditorType::class)
                ->setColumns(12),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(10)
            ->renderContentMaximized();
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
