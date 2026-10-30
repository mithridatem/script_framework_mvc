# MVC Advanced — Routing + Validation + Autowiring

Squelette pédagogique dérivé de `evaluationWeb/project_exemple`.
Il montre une inscription et une connexion avec séparation des responsabilités.

## Installation

```sh
composer install
# Modifier .env (notamment DATABASE_PASSWORD) si nécessaire
# Importer db.sql dans MySQL/MariaDB pour créer la base et la table user
php -S 127.0.0.1:8000 -t public
```

Accueil : http://127.0.0.1:8000/
Inscription : http://127.0.0.1:8000/register
Connexion : http://127.0.0.1:8000/login

## Architecture

- `public/index.php` : routeur + conteneur et démarrage session.
- `src/Controller` : gestion HTTP et rendu.
- `src/DTO` : données d'entrée et contraintes de validation.
- `src/Service` : orchestration des cas d'utilisation.
- `src/Repository` : persistance SQL via PDO.
- `src/Security` : hachage et session d'authentification.
- `config/service.php` : déclaration de la fabrique PDO dans le conteneur.

## Vérifier

```sh
php tests/register_user_input_test.php
php tests/login_input_test.php
```

Puis tester le parcours réel avec MySQL : inscription, doublon d'email, identifiants erronés, connexion et session. Ces tests autonomes ne remplacent pas des tests d'intégration.

Les contrôleurs emploient encore les helpers CSRF de `AbstractController` : c'est une base d'exercice pour leur future extraction en `Security/CsrfTokenManager`.

**Sécurité** : le squelette est pédagogique. Pour un déploiement public, ajouter limitation des tentatives, tests d'intégration et une gestion cohérente des exceptions SQL. Ne jamais committer `.env`.
