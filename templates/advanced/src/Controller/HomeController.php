<?php

namespace App\Controller;

use App\Controller\AbstractController;
use Mithridatem\Routing\Attribute\Route;
use Mithridatem\Routing\Http\RequestInterface;

final class HomeController extends AbstractController
{
    #[Route(path: '/', method: 'GET', grants: [])]
    public function home(): mixed
    {
        return $this->render('home', 'Accueil');
    }
}
