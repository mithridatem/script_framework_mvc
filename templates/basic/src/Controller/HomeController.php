<?php

declare(strict_types=1);

namespace App\Controller;

use Mithridatem\Routing\Attribute\Route;
use App\Service\ExampleService;

final class HomeController extends AbstractController
{
    #[Route(path: '/', method: 'GET', grants: [])]
    public function index(): void
    {
        // Sans conteneur, l'instanciation reste explicite pour les débutants.
        $service = new ExampleService();
        $this->render('home', 'Accueil MVC', ['message' => $service->greet('développeur')]);
    }
}
