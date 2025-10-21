# Lien Google Review - Documentation

## 📖 Comment fonctionne EZReview ?

### Le principe de l'application

**EZReview** est un système intelligent de gestion des avis clients qui permet de :

1. **Filtrer les avis selon leur satisfaction**
2. **Rediriger les bons avis vers Google** (pour améliorer votre e-réputation publique)
3. **Rediriger les mauvais avis vers une boîte mail privée** (pour gérer les problèmes en interne)

### Comment ça marche concrètement ?

#### 📧 Étape 1 : Envoi du questionnaire de satisfaction

Vous envoyez à vos clients un email avec un lien vers un questionnaire de satisfaction pour votre établissement.

#### ⭐ Étape 2 : Le client note son expérience

Le client clique sur le lien et arrive sur une page où il peut noter son expérience (généralement de 1 à 5 étoiles).

#### 🔀 Étape 3 : Redirection intelligente selon la note

**Si la note est POSITIVE (4 ou 5 étoiles)** :
- ✅ Le client est redirigé vers **Google Review** (avec le lien direct ou de fallback)
- ✅ Il peut laisser son avis public sur Google
- ✅ Cela améliore votre note globale sur Google Maps
- ✅ Les futurs clients verront ces bons avis

**Si la note est NÉGATIVE (1, 2 ou 3 étoiles)** :
- 📧 Le client est redirigé vers un **formulaire de contact privé**
- 📧 Il peut expliquer son insatisfaction
- 📧 Son retour est envoyé à **votre adresse email personnalisée** (badRevUrl)
- 🔒 L'avis reste **privé** et n'apparaît pas sur Google
- 💬 Vous pouvez le contacter directement pour résoudre le problème

### 🎯 Les avantages

✅ **Protège votre e-réputation** : Les avis négatifs ne sont pas publiés sur Google
✅ **Améliore votre note Google** : Seuls les clients satisfaits laissent des avis publics
✅ **Gestion proactive** : Vous êtes alerté des problèmes avant qu'ils ne deviennent publics
✅ **Relation client** : Vous pouvez résoudre les insatisfactions en privé

### 📊 Schéma du flux

```
┌─────────────────────────────────────────────────────────────────┐
│  VOUS : Envoyez un email avec lien questionnaire de satisfaction │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│  CLIENT : Clique sur le lien et note son expérience (1-5 ⭐)    │
└────────────────────────────┬────────────────────────────────────┘
                             │
                ┌────────────┴────────────┐
                │                         │
                ▼                         ▼
    ┌──────────────────────┐   ┌──────────────────────┐
    │  NOTE POSITIVE       │   │  NOTE NÉGATIVE       │
    │  (4-5 étoiles) ✨    │   │  (1-3 étoiles) 😞    │
    └──────────┬───────────┘   └──────────┬───────────┘
               │                           │
               ▼                           ▼
    ┌──────────────────────┐   ┌──────────────────────┐
    │ Redirection vers     │   │ Redirection vers     │
    │ GOOGLE REVIEW        │   │ FORMULAIRE PRIVÉ     │
    │ (lien public)        │   │ (badRevUrl)          │
    └──────────┬───────────┘   └──────────┬───────────┘
               │                           │
               ▼                           ▼
    ┌──────────────────────┐   ┌──────────────────────┐
    │ ✅ Avis public       │   │ 📧 Email à VOUS      │
    │ sur Google Maps      │   │ avec les détails     │
    │ → Améliore la note   │   │ → Gestion privée     │
    └──────────────────────┘   └──────────────────────┘
```

### 📋 Configuration d'un établissement

Pour chaque établissement/structure/société, vous devez configurer :

1. **Informations de base** :
   - Nom de l'établissement
   - Adresse complète (adresse, code postal, ville)
   - Logo/image (optionnel)

2. **Place ID Google (optionnel mais recommandé)** :
   - Permet de générer un lien **direct** vers le formulaire d'avis Google
   - Si non renseigné, un lien de **fallback** vers Google Maps est généré automatiquement

3. **URL pour les mauvais avis (badRevUrl)** :
   - L'adresse email ou l'URL du formulaire privé où seront envoyés les retours négatifs
   - Exemple : `mailto:contact@mon-restaurant.fr` ou URL d'un formulaire personnalisé

### 💼 Exemple concret : "Bistro d'Antan"

**Contexte** : Restaurant à Saint-Étienne qui veut gérer ses avis clients

**Configuration dans EZReview** :
- **Nom** : Bistro d'Antan
- **Adresse** : 15 rue de la République, 42000 Saint-Étienne
- **Place ID** : `ChIJabcd1234...` (optionnel)
- **badRevUrl** : `mailto:direction@bistro-dantan.fr`

**Scénario 1 - Client satisfait (Marie, 5 étoiles)** :
1. Marie reçoit l'email après son repas
2. Elle clique sur le lien et donne 5 étoiles ⭐⭐⭐⭐⭐
3. Elle est redirigée vers Google Review
4. Elle laisse un avis public : "Excellent restaurant, service impeccable !"
5. ✅ L'avis apparaît sur Google Maps et améliore la note du restaurant

**Scénario 2 - Client insatisfait (Pierre, 2 étoiles)** :
1. Pierre reçoit l'email après son repas
2. Il clique sur le lien et donne 2 étoiles ⭐⭐
3. Il est redirigé vers un formulaire de contact privé
4. Il écrit : "Plat froid et service trop lent"
5. 📧 Le restaurant reçoit un email à `direction@bistro-dantan.fr`
6. Le gérant contacte Pierre pour s'excuser et lui offrir un geste commercial
7. 🔒 L'avis négatif n'apparaît PAS sur Google
8. 💚 Pierre est satisfait de la réactivité et peut revenir

**Résultat** :
- La note Google du restaurant reste élevée (4.8/5)
- Les problèmes sont résolus en privé
- La relation client est préservée

---

## 🎯 Deux types de liens disponibles

Le système génère automatiquement le meilleur lien possible pour que vos clients laissent un avis Google.

### 1️⃣ Lien direct avec Place ID (OPTIMAL)

**Format** :
```
https://search.google.com/local/writereview?placeid=VOTRE_PLACE_ID
```

**Avantage** : ✨ Ouvre **directement** le formulaire d'avis Google

**Exemple** :
```
https://search.google.com/local/writereview?placeid=ChIJN1t_tDeuEmsRUsoyG83frY4
```

### 2️⃣ Lien de fallback sans Place ID (TOUJOURS DISPONIBLE)

**Format** :
```
https://www.google.com/maps/search/NOM_ETABLISSEMENT,+ADRESSE,+CODE_POSTAL,+VILLE
```

**Fonctionnement** : 🔍 Ouvre Google Maps avec votre établissement
- Vos clients verront la page Google Maps de votre établissement
- Ils devront cliquer sur **"Avis"** puis **"Écrire un avis"**

**Exemple** :
```
https://www.google.com/maps/search/Bistro+d'Antan,+15+rue+de+la+République,+42000,+Saint-Étienne
```

**Avantage** : ✅ Fonctionne **TOUJOURS**, même sans Place ID

## Ce qui a été mis en place

### 1. Méthodes dans l'entité Structure

Trois nouvelles méthodes ont été ajoutées dans `Structure.php` :

#### a) `getGoogleReviewUrl()` - Lien direct avec PID
```php
public function getGoogleReviewUrl(): ?string
{
    if (empty($this->Pid)) {
        return null;
    }
    return "https://search.google.com/local/writereview?placeid=" . $this->Pid;
}
```

#### b) `getGoogleFallbackUrl()` - Lien de secours sans PID
```php
public function getGoogleFallbackUrl(): string
{
    // Construit une URL de recherche Google Maps avec nom + adresse + ville
    $parts = [];
    if (!empty($this->name)) $parts[] = $this->name;
    if (!empty($this->adresse1)) $parts[] = $this->adresse1;
    if (!empty($this->cp)) $parts[] = $this->cp;
    if (!empty($this->city)) $parts[] = $this->city;

    $query = implode(', ', $parts);
    return "https://www.google.com/maps/search/" . urlencode($query);
}
```

#### c) `getBestGoogleReviewUrl()` - Lien optimal automatique
```php
public function getBestGoogleReviewUrl(): string
{
    // Priorise le lien avec PID, sinon fallback
    if (!empty($this->Pid)) {
        return $this->getGoogleReviewUrl();
    }
    return $this->getGoogleFallbackUrl();
}
```

### 2. Affichage dans le formulaire

Dans la page `/ezreview/settings`, pour chaque établissement :

#### Avec Place ID (encadré vert) :
- ✨ **Titre** : "Lien direct pour donner un avis Google"
- 📋 **Champ en lecture seule** : Affiche le lien direct avec PID
- 📝 **Bouton "Copier"** : Copie le lien dans le presse-papiers
- 🔗 **Bouton "Tester"** : Ouvre le lien dans un nouvel onglet
- ℹ️ **Message** : "Ce lien ouvre directement le formulaire d'avis Google"

#### Sans Place ID (encadré bleu) :
- 🔍 **Titre** : "Lien Google Maps de votre établissement"
- 📋 **Champ en lecture seule** : Affiche le lien de recherche Google Maps
- 📝 **Bouton "Copier"** : Copie le lien dans le presse-papiers
- 🔗 **Bouton "Tester"** : Ouvre le lien dans un nouvel onglet
- 💡 **Astuce** : "Remplissez le Place ID pour générer un lien direct"
- ℹ️ **Message** : "Ce lien ouvre Google Maps. Vos clients devront cliquer sur 'Avis' puis 'Écrire un avis'"

### 3. Fonctionnalités ajoutées

✅ **Génération automatique** du meilleur lien disponible (avec ou sans PID)
✅ **Lien de fallback** qui fonctionne TOUJOURS, même sans Place ID
✅ **Copie en un clic** dans le presse-papiers
✅ **Notification visuelle** de confirmation de copie
✅ **Bouton "Tester"** pour vérifier le lien
✅ **Indication visuelle** claire : vert (optimal avec PID) ou bleu (fallback sans PID)
✅ **Utilisation dans les emails** : Utilisez `{{ structure.bestGoogleReviewUrl }}` dans vos templates

## Comment l'utiliser ?

### Option 1 : AVEC Place ID (recommandé si possible)

1. **Renseignez le Place ID** de votre établissement (utilisez le bouton "Trouver le PID")
2. **Le lien direct est généré automatiquement** et s'affiche dans un encadré vert
3. **Copiez le lien** avec le bouton "Copier"
4. **Partagez-le** avec vos clients (par email, SMS, QR code, etc.)
5. **Vos clients cliquent** → Le formulaire d'avis Google s'ouvre directement ✨

### Option 2 : SANS Place ID (toujours fonctionnel)

1. **Remplissez les informations de base** : nom, adresse, code postal, ville
2. **Le lien de fallback est généré automatiquement** et s'affiche dans un encadré bleu
3. **Copiez le lien** avec le bouton "Copier"
4. **Partagez-le** avec vos clients
5. **Vos clients cliquent** → Google Maps s'ouvre sur votre établissement
6. **Vos clients cliquent** sur "Avis" puis "Écrire un avis" 📝

## Où partager ce lien ?

- Dans vos emails de suivi client
- Sur votre site web
- Dans vos signatures d'email
- Sur vos réseaux sociaux
- Dans des QR codes imprimés (cartes de visite, affiches, etc.)
- Dans vos campagnes SMS

## Notes importantes

### Lien avec Place ID
✅ Ouvre directement le formulaire d'avis (1 clic pour vos clients)
⚠️ Nécessite un Place ID valide
⚠️ L'utilisateur doit être connecté à un compte Google

### Lien de fallback (sans PID)
✅ Fonctionne TOUJOURS, même sans Place ID
✅ Basé sur le nom et l'adresse de votre établissement
⚠️ Nécessite 2 clics supplémentaires pour vos clients ("Avis" → "Écrire un avis")
⚠️ Si plusieurs établissements ont le même nom, Google Maps pourrait afficher une liste

💡 **Astuce** : Vous pouvez créer un QR code à partir de ces liens pour faciliter l'accès mobile !

## Utilisation dans les emails

Dans vos templates Twig d'emails, utilisez :

```twig
{# Lien optimal (avec PID si disponible, sinon fallback) #}
<a href="{{ structure.bestGoogleReviewUrl }}">Laissez-nous un avis</a>

{# Ou spécifiquement le lien de fallback #}
<a href="{{ structure.googleFallbackUrl }}">Trouvez-nous sur Google Maps</a>
```

## Fichiers modifiés

### Backend
- `app/src/Entity/EntityEZR/Structure.php`
  - `getGoogleReviewUrl()` - Lien direct avec PID
  - `getGoogleFallbackUrl()` - Lien de secours sans PID
  - `getBestGoogleReviewUrl()` - Lien optimal automatique
- `app/src/Controller/ControllerEZR/EzreviewController.php`
  - Méthode `survey()` mise à jour pour utiliser `getBestGoogleReviewUrl()`

### Frontend
- `app/templates/ezreview/macros/forms.html.twig` - Affichage conditionnel des liens (vert avec PID / bleu sans PID)
- `app/assets/js/copy_to_clipboard.js` - Fonction de copie dans le presse-papiers
- `app/templates/ezreview/ezreview_settings.html.twig` - Import du script JavaScript

---

**Date de mise à jour** : 2025-10-19
**Version** : 2.0 - Avec système de fallback
