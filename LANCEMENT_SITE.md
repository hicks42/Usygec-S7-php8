# 🚀 Guide de Lancement du Site USYGEC

## 📋 Prérequis

- Docker installé et fonctionnel
- Ports 8080 et 443 disponibles sur la machine hôte

## 🐳 Configuration Docker

Le site utilise Docker avec la configuration suivante :

### Container
- **Nom du container** : `USYGEC-S7-www-container`
- **Service** : `www-service`
- **Image** : Construite depuis `./docker/`

### Ports exposés
- **8080** → 80 (HTTP)
- **443** → 443 (HTTPS)

### Volumes montés
- `./docker/vhosts:/etc/apache2/sites-enabled`
- `./docker/ssl:/etc/apache2/ssl`
- `./app:/var/www/project/app` (💡 **Code source**)
- `./app/var/log/apache_log:/var/log/apache2`
- `./docker/php/php.ini:/usr/local/etc/php/php.ini`

## 🚀 Commandes de Lancement

### Démarrer le site
```bash
# Depuis le répertoire /home/patrice/WORK/USYGEC-S7/
docker-compose up -d
```

### Vérifier le statut
```bash
# Voir les containers en cours
docker ps | grep USYGEC

# Doit afficher quelque chose comme :
# CONTAINER ID   IMAGE                     COMMAND                  CREATED          STATUS          PORTS                                                                                  NAMES
# b072634ee232   usygec-s7-www-service   "docker-php-entrypoi…"   X minutes ago   Up X minutes   0.0.0.0:443->443/tcp, :::443->443/tcp, 0.0.0.0:8080->80/tcp, [::]:8080->80/tcp   USYGEC-S7-www-container
```

### Accéder au site
- **URL principale** : http://localhost:8080
- **HTTPS** : https://localhost:443 (si certificats SSL configurés)

## 🛠️ Commandes de Maintenance

### Redémarrer le container
```bash
docker restart USYGEC-S7-www-container
```

### Arrêter le site
```bash
docker-compose down
```

### Voir les logs Apache
```bash
docker exec USYGEC-S7-www-container tail -f /var/log/apache2/access.log
docker exec USYGEC-S7-www-container tail -f /var/log/apache2/error.log
```

### Accéder au shell du container
```bash
docker exec -it USYGEC-S7-www-container bash
```

### Exécuter du PHP dans le container
```bash
# Vérifier la version PHP
docker exec USYGEC-S7-www-container php --version

# Exécuter un script PHP
docker exec -w /var/www/project/app USYGEC-S7-www-container php -f public/index.php
```

## 📁 Structure des Fichiers

```
USYGEC-S7/
├── app/                          # 🎯 Code source du nouveau site
│   ├── public/
│   │   ├── index.php            # Page d'accueil principale
│   │   ├── favicon.ico          # Icône du site
│   │   └── assets/              # Images, CSS, JS (si nécessaire)
│   ├── .env                     # Configuration environnement
│   └── composer.json            # Dépendances PHP (si Symfony utilisé)
├── OLD_app/                     # 📦 Ancien site Symfony (sauvegarde)
├── docker/                      # 🐳 Configuration Docker
│   ├── vhosts/
│   ├── ssl/
│   └── php/
├── docker-compose.yml           # Configuration Docker Compose
└── LANCEMENT_SITE.md           # 📖 Ce guide !
```

## 🔧 Configuration Apache

### Virtual Host Principal
- **DocumentRoot** : `/var/www/project/app/public`
- **DirectoryIndex** : `/index.php`
- **FallbackResource** : `/index.php` (toutes les URLs redirigent vers index.php)

### Configuration dans le container
```apache
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot /var/www/project/app/public
    DirectoryIndex /index.php

    <Directory /var/www/project/app/public>
        AllowOverride None
        Order Allow,Deny
        Allow from All
        FallbackResource /index.php
    </Directory>
</VirtualHost>
```

## 🧪 Tests de Fonctionnement

### Test rapide
```bash
# Test de connectivité
curl -s http://localhost:8080/ | head -5

# Doit retourner :
# <!DOCTYPE html>
# <html>
#     <head>
#         <meta charset="UTF-8">
#         <title>USYGEC - Accueil</title>
```

### Test complet
```bash
# Vérifier les éléments clés de la page
curl -s http://localhost:8080/ | grep -E "<title>|<h1>|<h2>|Time2Gether"

# Doit afficher :
# <title>USYGEC - Accueil</title>
# <h1>USYGEC</h1>
# <h2>Union Sportive Yves Gibrat Escalade Cyclosport</h2>
# <h4>Time2Gether</h4>
```

## 🚨 Dépannage

### Le site ne répond pas
1. Vérifier que le container tourne :
   ```bash
   docker ps | grep USYGEC
   ```

2. Si le container n'est pas démarré :
   ```bash
   docker-compose up -d
   ```

3. Si le port 8080 est occupé :
   ```bash
   # Voir qui utilise le port
   lsof -i :8080
   
   # Ou changer le port dans docker-compose.yml
   ```

### Erreur 500 ou page blanche
1. Vérifier les logs Apache :
   ```bash
   docker exec USYGEC-S7-www-container tail -n 50 /var/log/apache2/error.log
   ```

2. Vérifier les permissions du fichier index.php :
   ```bash
   ls -la app/public/index.php
   ```

3. Tester PHP directement :
   ```bash
   docker exec USYGEC-S7-www-container php -l /var/www/project/app/public/index.php
   ```

### Container ne démarre pas
1. Reconstruire l'image :
   ```bash
   docker-compose build --no-cache
   docker-compose up -d
   ```

2. Vérifier les logs du container :
   ```bash
   docker logs USYGEC-S7-www-container
   ```

## 📝 Notes Importantes

- ⚠️ **Ne pas supprimer** le dossier `OLD_app/` - c'est la sauvegarde de l'ancien site
- 🔄 **Redémarrage automatique** : Le container redémarre automatiquement en cas de crash (`restart: on-failure:5`)
- 💾 **Modifications en temps réel** : Les modifications dans `app/` sont immédiatement visibles (volume monté)
- 🌐 **Réseau** : Le container utilise le réseau `USYGEC-ntw` (bridge externe)

## 🎯 Prochaines Étapes

1. **Développer le contenu** : Modifier `app/public/index.php`
2. **Ajouter des pages** : Créer d'autres fichiers PHP dans `app/public/`
3. **Intégrer Symfony** : Si besoin d'un framework plus complet
4. **Configurer HTTPS** : Utiliser les certificats SSL dans `docker/ssl/`
5. **Base de données** : Ajouter un service MySQL/PostgreSQL si nécessaire

---

*📅 Guide créé le 6 septembre 2025*  
*🔧 Dernière mise à jour : Site fonctionnel avec page d'accueil USYGEC et promotion Time2Gether*