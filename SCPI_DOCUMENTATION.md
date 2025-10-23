# Documentation Section SCPI

## Contexte du Projet

La section SCPI du site est actuellement en cours de refonte. Cette section permet de comparer des produits d'investissement SCPI.

### Migration Technique

- **Avant** : Webpack + SCSS
- **Après** : AssetMapper + Tailwind CSS
- **Statut** : La migration est effectuée mais les fonctionnalités ne marchent plus comme avant

## Architecture

### Fichiers Concernés

- **Controllers** : Fichiers avec `*SCPI` dans le nom
  - `app/src/Controller/ControllerSCPI/CartController.php`
  - `app/src/Controller/ControllerSCPI/HomepageController.php`

- **Templates** : Répertoire `app/templates/scpi/`
  - `app/templates/scpi/base.html.twig`
  - `app/templates/scpi/scpi_hp.html.twig`
  - `app/templates/scpi/produit/produits.html.twig`
  - `app/templates/scpi/produit/produit_show.html.twig`
  - `app/templates/scpi/produit/compare.html.twig`
  - `app/templates/scpi/traits/_hpheader.html.twig`

- **Base de données** : Tables avec préfixe `mc_*`
  - Fichier SQL : `mc_tables.sql`
  - Table principale : `mc_produits`

### Entities et Repositories
- **Entities** : `app/src/Entity/EntitySCPI/`
- **Repositories** : `app/src/Repository/RepositorySCPI/`

## Fonctionnalités Requises

### 1. Liste des Produits (Cards)

- Affichage des produits sous forme de cartes
- Chaque carte affiche **quelques critères seulement** (version simplifiée)
- Les produits doivent être sélectionnables

### 2. Panier de Comparaison (Cart)

#### Comportement du Cart

- **Affichage en temps réel** : Le cart s'affiche à l'écran pendant la navigation
- **Visibilité** : Le cart doit permettre de continuer à voir les cartes produits de la page
- **Capacité** : Maximum 3 produits
- **Gestion** :
  - Réserver des emplacements vides (afficher 3 emplacements même si vides)
  - Possibilité d'ajouter des produits
  - Possibilité de retirer des produits
  - Actions possibles pendant le browsing des cartes

#### Position du Cart

Le cart doit être positionné de manière à ne pas bloquer la visualisation des cartes produits (probablement en position fixe sur le côté ou en bas de l'écran).

### 3. Comparaison Détaillée

#### Déclenchement

- Bouton "Comparer en détail" dans le cart

#### Affichage

- **Layout** : 2 ou 3 colonnes selon le nombre de produits sélectionnés
- **Contenu** : **TOUS** les champs de la table `mc_produits`
- **Objectif** : Permettre une comparaison côte à côte, critère par critère

#### Structure de la Comparaison

```
| Critère          | Produit 1 | Produit 2 | Produit 3 |
|------------------|-----------|-----------|-----------|
| Nom              | ...       | ...       | ...       |
| Prix             | ...       | ...       | ...       |
| Rendement        | ...       | ...       | ...       |
| [Tous les champs de mc_produits]                      |
```

## Workflow Utilisateur

1. L'utilisateur browse les cartes de produits
2. Il sélectionne jusqu'à 3 produits (qui s'ajoutent au cart)
3. Le cart reste visible en permanence avec les produits sélectionnés
4. L'utilisateur peut ajouter/retirer des produits à tout moment
5. Quand prêt, il clique sur "Comparer en détail"
6. Une vue de comparaison complète s'affiche avec tous les critères

## Problèmes Identifiés et Résolus ✅

### 1. Import incorrect du Repository (ProduitController.php:8)
- **Problème** : Importait `RepositorySD\ProduitRepository` au lieu de `RepositorySCPI\ProduitRepository`
- **Solution** : Correction de l'import vers le bon namespace SCPI
- **Impact** : Les produits ne s'affichaient pas sur la page scpi/produits

### 2. Méthode findOneBySlug manquante (ProduitRepository.php)
- **Problème** : Le `ProduitRepository` n'avait pas la méthode `findOneBySlug` utilisée par le controller (ligne 45)
- **Solution** : Ajout de la méthode dans `RepositorySCPI/ProduitRepository.php`
- **Impact** : Impossible d'afficher la page détail d'un produit

### 3. Typo dans l'attribut data (compare.js:124 et produits.html.twig:101)
- **Problème** : `datat-produit-obj` au lieu de `data-produit-obj`
- **Solution** : Correction de la typo dans le template et le JavaScript
- **Impact** : Le bouton "Ajouter" ne fonctionnait pas

### 4. Affichage du popup de comparaison (compare.js:103-116)
- **Problème** : Le popup utilisait des classes CSS `.active` qui n'existent pas dans Tailwind
- **Solution** : Remplacement par les classes Tailwind appropriées :
  - Ouverture : `translate-y-0` et `opacity-100`
  - Fermeture : `-translate-y-64` et `opacity-0`
- **Impact** : Le cart de comparaison restait invisible

### 5. Routes incorrectes dans CompareController (lignes 22, 86, 108, 116)
- **Problème** : Toutes les routes utilisaient `scip` au lieu de `scpi`
- **Solution** : Correction des routes et des chemins de templates (lignes 78, 103)
- **Impact** : Erreur 404 lors du clic sur "Comparez"

## Statut Final

### ✅ Fonctionnalités Opérationnelles
- Affichage des produits SCPI dans des cartes avec critères simplifiés
- Sélection de produits via bouton "Ajouter"
- Affichage temps réel du cart (popup) avec animation
- Limitation à 3 produits maximum dans le cart
- Affichage de 3 emplacements (même si vides)
- Bouton "Retirer le dernier" fonctionnel
- Redirection vers la page de comparaison détaillée

### 🔄 À Tester
- La page de comparaison détaillée (scpi/comparator/{ids})
- L'affichage de tous les champs de mc_produit dans la comparaison
- Le layout 2 ou 3 colonnes selon le nombre de produits

## État de la Migration

### Fichiers Supprimés (SCIP - ancienne version)

- Controllers SCIP (ancien nom)
- Templates SCIP
- Entities/Repositories SCIP

### Fichiers Actifs (SCPI - nouvelle version)

- Controllers SCPI mis à jour
- Templates SCPI adaptés à Tailwind
- Entities/Repositories SCPI

## Technologies

- **Backend** : Symfony
- **Frontend** : Tailwind CSS + AssetMapper
- **JavaScript** : À vérifier pour les interactions du cart
- **Base de données** : MySQL/MariaDB (tables mc_*)

## Notes Techniques

- La refonte a renommé SCIP en SCPI
- L'intégration dans le site principal a été effectuée
- Les styles SCSS ont été convertis en classes Tailwind
- Le système de build Webpack a été remplacé par AssetMapper

## Prochaines Étapes

1. Analyser le fonctionnement actuel du cart
2. Identifier les scripts JavaScript manquants/cassés
3. Restaurer la fonctionnalité de sélection temps réel
4. Vérifier la page de comparaison détaillée
5. Tester le workflow complet de comparaison
