<?php

declare(strict_types=1);

namespace App\Security;

/** Responsable uniquement de la représentation sécurisée des mots de passe. */
final class PasswordHasher
{
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verify(string $plainPassword, string $hash): bool
    {
        return password_verify($plainPassword, $hash);
    }
}
