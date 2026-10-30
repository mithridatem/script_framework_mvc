<?php

namespace App\Controller;

use App\DTO\RegisterUserInput;
use App\Service\UserService;
use Mithridatem\Routing\Attribute\Route;
use Mithridatem\Routing\Http\RequestInterface;

final class RegisterController extends AbstractController
{
    public function __construct(private UserService $userService) {}

    #[Route(path: '/register', method: ['GET', 'POST'], grants: [])]
    public function register(RequestInterface $request): mixed
    {
        if ($this->isFormSubmitted($request)) {
            if (!$this->isCsrfTokenValid(['csrf_token' => $request->post('csrf_token')])) {
                return $this->render('register', 'Inscription', [
                    'errors' => 'Formulaire expiré. Veuillez réessayer.',
                ]);
            }
            $input = RegisterUserInput::fromArray([
                'firstname' => $request->post('firstname'),
                'lastname' => $request->post('lastname'),
                'email' => $request->post('email'),
                'password' => $request->post('password'),
                'confirm_password' => $request->post('confirm_password'),
            ]);

            $data = $this->userService->register($input);
        }

        return $this->render('register', 'Inscription', $data ?? []);
    }
}
