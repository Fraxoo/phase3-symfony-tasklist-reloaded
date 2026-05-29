# Phase3 Symfony Tasklist — Instructions d'installation et d'exécution

Ce dépôt contient une application Symfony (template de gestion de tâches). Ce document décrit les prérequis, l'installation locale et via Docker, et les commandes utiles pour lancer le projet en développement ou en production.

## Prérequis

- PHP >= 8.4
- Composer (2.x)
- Node.js (recommandé >= 18) et `npm` / `yarn` — seulement si vous gérez des assets manuellement
- Docker & Docker Compose (optionnel, recommandé pour un environnement isolé)

Fichiers importants : `composer.json`, `compose.yaml`, `Dockerfile`, `bin/console`, `bin/phpunit`.

## Installation locale (développement)

1. Cloner le dépôt puis se placer dans le dossier du projet :

```bash
git clone <repo-url> phase3-symfony-tasklist-reloaded
cd phase3-symfony-tasklist-reloaded
```

2. Installer les dépendances PHP :

```bash
composer install
```

3. Copier le fichier d'environnement et adapter si besoin :

```bash
cp .env .env.local
# Modifier .env.local pour DATABASE_URL ou autres variables d'environnement
```

Par défaut, le `compose.yaml` configure `DATABASE_URL` pour utiliser SQLite dans `var/`.

4. Créer la base de données et exécuter les migrations :

```bash
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
```

5. (Optionnel) Charger des fixtures de développement :

```bash
php bin/console doctrine:fixtures:load --no-interaction
```

6. Assets : selon la configuration du projet vous n'aurez peut-être pas de `package.json`. Si vous utilisez des outils JS/CSS, installez-les puis build :

```bash
# si package.json présent
npm install
npm run dev   # ou `npm run build` pour une version de production

# sinon, assurez-vous que les assets sont installés via Symfony
php bin/console assets:install
```

7. Lancer le serveur local (Symfony CLI recommandé) :

```bash
symfony server:start
# ou
php -S 127.0.0.1:8000 -t public
```

Accéder ensuite à `http://localhost:8000` (ou le port configuré).

## Exécution via Docker 

Le dépôt fournit un `compose.yaml`. Pour lancer les services :

```bash
 docker compose build --pull --no-cache
 docker compose up --wait

# ouvrir un shell dans le conteneur PHP
docker compose exec php bash

# puis, dans le conteneur :
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
```

Le conteneur PHP monte le dossier `./var` sur l'hôte afin de conserver la base SQLite entre redémarrages (voir `compose.yaml`).

## Commandes utiles

- Installer dépendances PHP : `composer install`
- Lancer migrations : `php bin/console doctrine:migrations:migrate`
- Charger fixtures : `php bin/console doctrine:fixtures:load`
- Lancer tests : `./bin/phpunit` ou `php ./bin/phpunit`
- Installer assets Symfony : `php bin/console assets:install`

