<?php

namespace App\Controller;

use Mithridatem\Routing\Http\RequestInterface;

abstract class AbstractController
{
    /**
     * Méthode pour rendre une vue avec un template
     * @param string $template Le nom du template à inclure
     * @param string|null $title Le titre de la page
     * @param array $data Les données à passer au template
     * @return mixed
     */
    protected function render(string $template, ?string $title, array $data = []): mixed
    {
       return include __DIR__ . "/../../template/template_" . $template . ".php";
    }

    /**
     * Méthode pour générer un composant
     * @param string $component Le nom du template à inclure
     * @param array $data Les données à passer au composant
     * @return void
     */
    protected function renderComponent(string $component, array $data = []): void
    {
        include __DIR__ . "/../../template/component/component_" . $component . ".php";
    }

    /**
     * Méthode pour envoyer une réponse JSON
     * @param array $data Les données à encoder en JSON
     * @param int $statusCode Le code de statut HTTP
     * @return void
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
    
    /**
     * Méthode pour vérifier si un formulaire a été soumis
     * @param RequestInterface $request La requête HTTP
     * @return bool Vrai si le corps de la requête n'est pas vide, faux sinon
     */
    protected function isFormSubmitted(RequestInterface $request): bool
    {
        return !empty($request->getContent());
    }

    /**
     * Méthode pour générer un Token CSRF
     * @return string $token CSRF Token
     */
    protected function getCsrfToken(): string
    {
        if (empty($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        }

        return $_SESSION["csrf_token"];
    }

    /**
     * Méthode pour tester la validé du token CSRF
     * @return bool $token true si valide false invalide 
     */
    protected function isCsrfTokenValid(array $post): bool
    {
        $token = $post["csrf_token"] ?? "";
        $sessionToken = $_SESSION["csrf_token"] ?? "";

        return !empty($token) && !empty($sessionToken) && hash_equals($sessionToken, $token);
    }
}
