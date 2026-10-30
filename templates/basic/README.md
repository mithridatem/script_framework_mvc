# MVC Basic

Ce projet utilise seulement `mithridatem/router` : pas de conteneur ni de librairie de validation.

```sh
composer install
php -S 127.0.0.1:8000 -t public
```

Ouvrez http://127.0.0.1:8000/.

- `public/index.php` : routeur et point d'entrée.
- `src/Controller` : entrée/sortie HTTP.
- `src/Service` : logique métier.
- `src/Repository` : persistance PDO.
- `src/Entity` : objets métier.
- `templates` : vues.

Le squelette n'a pas besoin de MySQL pour la page d'accueil. La configuration `.env` sert d'exemple et n'est pas lue automatiquement.
