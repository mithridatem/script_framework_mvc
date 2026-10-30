<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;

/** Encapsule la représentation de l'utilisateur authentifié en session PHP. */
final class UserSessionManager
{
    public function login(User $user): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            throw new \LogicException('Une session PHP doit être démarrée avant la connexion.');
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'grant' => array_values(array_filter(
                array_map('trim', explode(',', $user->getGrant() ?? '')),
                static fn (string $grant): bool => $grant !== ''
            )),
        ];
    }

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            throw new \LogicException('Une session PHP doit être démarrée avant la déconnexion.');
        }

        unset($_SESSION['user']);
        session_regenerate_id(true);
    }
}
