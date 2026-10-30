<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\LoginInput;
use App\Repository\UserRepository;
use App\Security\PasswordHasher;
use Mithridatem\Validation\Validator;

final class LoginService
{
    public function __construct(
        private UserRepository $users,
        private Validator $validator,
        private PasswordHasher $hasher,
    ) {}

    /** @return array{validation?: array, errors?: string, user?: \App\Entity\User} */
    public function login(LoginInput $input): array
    {
        $violations = $this->validator->validate($input);
        if ($violations !== []) {
            return ['validation' => $violations];
        }

        $user = $this->users->findByEmail($input->email);
        if ($user === null || !$this->hasher->verify($input->password, $user->getHashPassword() ?? '')) {
            return ['errors' => 'Email ou mot de passe incorrect'];
        }

        return ['user' => $user];
    }
}
