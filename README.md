# TaskList Symfony

[![Symfony](https://img.shields.io/badge/Symfony-6.x-black?logo=symfony)](https://symfony.com/)
[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php)](https://www.php.net/)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwindcss)](https://tailwindcss.com/)


Petit projet **TaskList** développé avec Symfony afin de m’entraîner sur le framework et la création d’une application CRUD complète.

---

## Aperçu

![App Screenshot](./docs/screenshot.png)


---


## Fonctionnalités

- Création, modification et suppression de tâches
- Gestion des statuts (en cours / terminé)
- Filtrage des tâches

---

## Stack technique

- Symfony (Framework PHP)
- PHP 8+
- Tailwind CSS
- Doctrine ORM
- SQLite
- Composer

---

## Installation

Cloner le projet :

```bash
git clone https://github.com/Fraxoo/phase3-symfony-tasklist-reloaded.git
cd phase3-symfony-tasklist-reloaded
```

Installer les dépendances PHP :

```bash
composer install
```

Créer la base de données et exécuter les migrations :

```bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

---

## Lancer le projet

Démarrer le serveur Symfony :

```bash
symfony server:start
```

Cliquer sur le lien Afficher dans la console pour acceder au site

Compiler Tailwind en mode watch :

```bash
symfony console tailwind:build --watch
```

## Auteur

**John Hardy** — [@Fraxoo](https://github.com/Fraxoo)