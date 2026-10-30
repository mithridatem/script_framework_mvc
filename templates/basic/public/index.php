<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Mithridatem\Routing\Exception\MethodNotAllowedException;
use Mithridatem\Routing\Exception\RouteNotFoundException;
use Mithridatem\Routing\Loader\AttributeRouteLoader;
use Mithridatem\Routing\Router;

$router = new Router();

// Découverte automatique : les contrôleurs abstraits sont ignorés.
(new AttributeRouteLoader())->loadDirectory(
    router: $router,
    directory: dirname(__DIR__) . '/src/Controller',
    namespace: 'App\\Controller'
);

try {
    $router->dispatch();
} catch (RouteNotFoundException $error) {
    http_response_code(404);
    echo 'Page introuvable';
} catch (MethodNotAllowedException $error) {
    http_response_code(405);
    echo 'Méthode HTTP interdite';
}
