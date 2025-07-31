# script_framework_mvc
**Le script permet de construire un projet PHP MVC**

**Prérequis** :
- PHP 8.2 +
- Serveur Apache
- BDD Mysql
- Composer 2.8 +
- Git Bash avec tar et curl

**Etapes d'installation**
- 1 Télécharger le fichier script.sh
- 2 Lancer le script avec la commande suivante dans Git Bash:
```sh
bash script.sh
```
**Comment ça marche ?**

le script va générer une struture de  projet PHP MVC.
Vous devez répondre aux questions suivantes (dans le terminal):
- 1 nom de votre projet ? (nom du dossier)
- 2 Le nom de votre BDD ?
- 3 Le login de votre BDD ?
- 4 Le password de votre BDD ?
- 5 l'hote du serveur de BDD ? (localhost en local)
- 6 L'emplacement de la racine de Apache ? (htdocs / www)

Vous aurez un projet configuré avec la structure suivante :
```txt
|-- App
|   |-- Controller
|   |   |-- AbstractController.php
|   |   `-- HomeController.php
|   |-- Model
|   |   |-- AbstractModel.php
|   |   `-- Exemple.php
|   |-- Repository
|   |   `-- AbstractRepository.php
|   |-- Router
|   |   |-- Route.php
|   |   |-- Router.php
|   |   `-- RouterException.php
|   |-- Service
|   |   `-- ExempleService.php
|   `-- Utils
|       `-- Bdd.php
|-- composer.json
|-- composer.lock
|-- env.local.php
|-- index.php
|-- public
|   `-- assets
|       |-- img
|       |   `-- test.png
|       |-- scripts
|       |   `-- main.js
|       `-- styles
|           `-- main.css
|-- templates
|   |-- base.php
|   |-- footer.php
|   |-- header.php
|   `-- view
|       |-- view404.php
|       `-- viewHome.php


14 directories, 23 files
```
**Créer votre première page** :
- 1 Créer un nouveau **Controller** (voir exemple HomeController)
Il doit hériter de AbstractController pour bénéfier des méthodes de celui-ci

- 2 Créer un nouveau **template** dans le dossier templates/view

Il va correspondre au **body** de la page (tout ce qui est contenu entre la navbar et le footer)

Exemple :
```php
<?php ob_start() ?>
<!-- code HTML et PHP de la page -->
<h1>Page d'Accueil</h1>
<h2>Bienvenue</h2>
<?php $body = ob_get_clean() ?>
```
Le code de la page est stocké dans une variable $body

**NB** : *Toutes les pages sont basées sur le template de base.php* 

- 3 Créer une nouvelle méthode dans votre controller

Elle va retourner la méthode render qui compose la vue

Exemple :
```php
//la méthode render posséde les paramètres suivants :
//1 le chemin du template depuis /templates (sans le .php). Obligatoire
//2 le titre de la page (affiché dans l'onglet du navigateur web). Par défaut c'est titre
//3 la variable array $data pour faire passer des données à la vue. Par défaut le tableau est vide
//4 la variable array $error pour faire passer des messages d'erreur à la vue. Par défaut le tableau est vide 
public function home() {
    return $this->render("view/viewHome", "home");
}
```
- 4 Créer une nouvelle route dans index.php

Exemple :
```php
//le constructeur prend les paramètres suivants :
//1 le chemin de la route (après http://localhost/dossier_projet)
//2 la méthode HTTP (GET pour affichage, POST récupération des données d'un formulaire)
//3 Le nom du controller (sans Controller à la fin : Home pour HomeController dans l'exemple)
//4 le nom de la méthode du controller (sans les parenthéses home pour home() dans l'exemple)
$router->addRoute(new Route('/', 'GET', 'Home', 'home'));
```
Pour des explications plus avancées  :

- gestion des requêtes SQL 
- et autre 
n'hésitez pas à me demander je rajouterai des exemples.

Enjoy !!!
