# Générateur PHP MVC — Basic et Advanced

Projet pédagogique de génération de squelettes PHP avec les librairies open source
`mithridatem/router`, `mithridatem/validation`, `mithridatem/autowiring`.

## Deux profils

| Profil | Dépendances | Objectif |
|---|---|---|
| **Basic** | Routing uniquement | Comprendre MVC, contrôleur, service, repository, entité |
| **Advanced** | Routing, Validation, Autowiring | DTO, contraintes par attributs, injection de dépendances, inscription/connexion |

Les classes de base sont copiées dans chaque projet et peuvent être modifiées ; elles ne font pas partie d'une quatrième librairie.

## Prérequis

PHP 8.2+, Composer 2, Bash (Linux/macOS ou Git Bash sous Windows).
Une instance MySQL/MariaDB n'est nécessaire que pour les pages d'authentification du profil Advanced.

## Utilisation

```bash
git clone https://github.com/mithridatem/script_framework_mvc.git
cd script_framework_mvc

# BAC+2 : router seul, MVC simple
bash script.sh --profile basic --name demo_basic

# Licence 3/4 : les 3 librairies
bash script.sh --profile advanced --name demo_advanced --db-name demo_school

# Mode interactif
bash script.sh
```

Options : `--name`, `--profile`, `--target`, `--no-install`, `--db-host`, `--db-port`, `--db-name`, `--db-user`, `--configure-db`, `--help`.

Le script refuse d'écraser un projet existant et ne publie pas les secrets en console.
Avec `--configure-db`, il demande le mot de passe sans l'afficher (TTY requis).
Sinon renseigner `DATABASE_PASSWORD` dans le `.env` généré.
Le fichier `.env` est ignoré par Git.

## Démarrer le projet

```bash
cd demo_basic  # ou demo_advanced
composer install
php -S 127.0.0.1:8000 -t public
```

Pour Advanced : importer le script `db.sql` dans MySQL/MariaDB et vérifier les paramètres de `.env`. Voir le README généré.

## Tests du générateur

```bash
bash tests/smoke-basic.sh
bash tests/smoke-advanced.sh
```

Ces tests vérifient les fichiers, les paramètres et la syntaxe PHP (sans dépendances).
Après installation Composer, exécuter les tests et les parcours HTTP indiqués dans le README du projet généré.

L'ancienne archive `archivev2.tar.gz` reste dans l'historique mais n'est plus utilisée.
