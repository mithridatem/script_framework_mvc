<?php

declare(strict_types=1);

// Lancer : php tests/login_input_test.php
require dirname(__DIR__) . '/vendor/autoload.php';

use App\DTO\LoginInput;
use App\Security\PasswordHasher;
use Mithridatem\Validation\Validator;

function expectLogin(bool $ok, string $message): void
{
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$input = LoginInput::fromArray(['email' => '  ada@example.test ', 'password' => ' secret<&> ']);
expectLogin($input->email === 'ada@example.test', 'Email non normalisé');
expectLogin($input->password === ' secret<&> ', 'Le mot de passe ne doit pas être transformé');
expectLogin((new Validator())->validate($input) === [], 'Entrée valide rejetée');

$invalid = LoginInput::fromArray(['email' => ['invalid'], 'password' => null]);
expectLogin($invalid->email === null, 'Tableau inattendu non géré');
expectLogin((new Validator())->validate($invalid) !== [], 'Entrée invalide acceptée');

$hasher = new PasswordHasher();
$hash = $hasher->hash('secret<&>');
expectLogin($hasher->verify('secret<&>', $hash), 'Mot de passe valide rejeté');
expectLogin(!$hasher->verify('wrong', $hash), 'Mot de passe invalide accepté');
echo "Login DTO et PasswordHasher : OK\n";
