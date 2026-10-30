<?php

declare(strict_types=1);

namespace App\Controller;

use Mithridatem\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route(path: '/', method: 'GET', grants: [])]
    public function index(): void
    {
        $this->render('home', 'Accueil MVC');
    }
}
