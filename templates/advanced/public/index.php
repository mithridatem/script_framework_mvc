<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Mithridatem\Autowiring\Container;
use Mithridatem\Autowiring\Bridge\Routing\ContainerControllerResolver;
use Mithridatem\Routing\Auth\ArrayGrantChecker;
use Mithridatem\Routing\Exception\RouterException;
use Mithridatem\Routing\Exception\RouteNotFoundException;
use Mithridatem\Routing\Exception\UnauthorizedException;
use Mithridatem\Routing\Loader\AttributeRouteLoader;
use Mithridatem\Routing\Router;

//Headers sécurité
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header("Content-Security-Policy: default-src 'self'; style-src 'self' https://cdn.jsdelivr.net; img-src 'self' data:; script-src 'self'; object-src 'none'; frame-ancestors 'none';");

//Configuration session
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => !empty($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax',
]);

ini_set('session.use_strict_mode', '1');
session_start();

//importer les variables d'environnement 
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Charger les dépendances de l'application.
$container = (new Container())->load(
    dirname(__DIR__) . '/config/service.php'
);

// Le routeur délègue la construction des contrôleurs au conteneur.
$router = new Router();
$router->setControllerResolver(
    new ContainerControllerResolver($container)
);

// Conserver ici les éventuels réglages de basePath et d'autorisations.
$router->setGrantChecker(
    new ArrayGrantChecker($_SESSION["user"]["grant"] ?? [])
);

// Charger les routes déclarées dans les contrôleurs avec #[Route].
(new AttributeRouteLoader())->loadDirectory(
    router: $router,
    directory: dirname(__DIR__) . '/src/Controller',
    namespace: 'App\\Controller'
);
//Dispatch des routes
try {
    $router->dispatch();
} catch (RouterException $e) {
    echo $e->getMessage();
} catch (RouteNotFoundException $e) {
    echo $e->getMessage();
} catch (UnauthorizedException $e) {
    echo $e->getMessage();
}
