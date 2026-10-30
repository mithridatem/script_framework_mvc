# Générateur pédagogique de projets PHP MVC

Ce dépôt génère un squelette PHP MVC avec **uniquement `mithridatem/router`** dans son profil Basic.

Les classes `AbstractController`, `AbstractRepository`, etc. sont copiées dans le projet : elles sont destinées à être étudiées et modifiées, et ne nécessitent pas une librairie PHP supplémentaire.

## Prérequis

PHP 8.2+, Composer 2 et Bash (Linux, macOS ou Git Bash sous Windows).

## Création

```bash
git clone https://github.com/mithridatem/script_framework_mvc.git
cd script_framework_mvc
bash script.sh --name demo
# ou : bash script.sh   (mode interactif)
```

Options : `--target /dossier/parent`, `--no-install`, `--help`.
Le script refuse d'écraser un répertoire existant.

```bash
cd demo
php -S 127.0.0.1:8000 -t public
```

Ouvrir http://127.0.0.1:8000/.

## Structure

Le générateur copie `templates/basic` et lance Composer si disponible.
L'ancienne archive `archivev2.tar.gz` n'est plus utilisée.

## Vérification

```bash
bash tests/smoke-basic.sh
```

Ce squelette volontairement minimal prépare le passage à une architecture en couches puis à Symfony.
