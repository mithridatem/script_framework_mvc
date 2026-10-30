<?php

declare(strict_types=1);

namespace App\Controller;

use Mithridatem\Routing\Http\RequestInterface;

abstract class AbstractController
{
    protected function render(string $view, string $title = 'Accueil', array $data = []): void
    {
        $path = dirname(__DIR__, 2) . '/templates/' . $view . '.php';
        if (!is_file($path)) {
            throw new \RuntimeException('Vue absente : ' . $view);
        }
        require $path;
    }

    protected function isFormSubmitted(RequestInterface $request): bool
    {
        return strtoupper($request->getMethod()) === 'POST';
    }

    protected function redirect(string $path): never
    {
        header('Location: ' . $path, true, 303);
        exit;
    }
}
