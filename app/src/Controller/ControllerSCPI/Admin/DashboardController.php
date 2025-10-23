<?php

namespace App\Controller\ControllerSCPI\Admin;

use App\Entity\EntitySCPI\Actu;
use App\Entity\EntitySCPI\User;
use App\Entity\EntitySCPI\Produit;
use App\Entity\EntitySCPI\Categorie;
use App\Controller\ControllerSCPI\Admin\ProduitCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private $adminUrlGen;

    public function __construct(AdminUrlGenerator $adminUrlGen)
    {
        $this->adminUrlGen = $adminUrlGen;
    }

    #[Route("/admin", name:"admin")]
    public function index(): Response
    {
        // return parent::index();

        // redirect to some CRUD controller
        $routeBuilder = $this->adminUrlGen;

        return $this->redirect($routeBuilder->setController(ProduitCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<a href="/scpi/home">SCPI</a>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Actus', 'fa fa-newspaper', Actu::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-tag', Categorie::class);
        yield MenuItem::linkToCrud('Produits', 'fa fa-box', Produit::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
    }
}
