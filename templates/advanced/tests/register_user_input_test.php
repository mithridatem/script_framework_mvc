<?php

declare(strict_types=1);

// Test autonome : php tests/register_user_input_test.php
require dirname(__DIR__) . '/vendor/autoload.php';

use App\DTO\RegisterUserInput;
use App\Security\PasswordHasher;
use Mithridatem\Validation\Validator;

function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$input = RegisterUserInput::fromArray([
    'firstname' => '  Ada  ',
    'lastname' => ' Lovelace ',
    'email' => ' ada@example.test ',
    'password' => '  pass<&>  ',
    'confirm_password' => '  pass<&>  ',
]);
check($input->firstname === 'Ada', 'Le prénom doit être normalisé.');
check($input->email === 'ada@example.test', "L'email doit être normalisé.");
check($input->password === '  pass<&>  ', 'Le mot de passe ne doit pas être transformé.');
check($input->password === $input->confirmPassword, 'La confirmation doit rester identique.');

$invalid = RegisterUserInput::fromArray([
    'firstname' => ['unexpected'],
    'lastname' => '',
    'email' => 'invalid',
    'password' => '',
    'confirm_password' => '',
]);
check($invalid->firstname === null, 'Une entrée tableau doit être rejetée sans TypeError.');
$validator = new Validator();
check($validator->validate($invalid) !== [], 'Les contraintes du DTO doivent détecter les erreurs.');

$hasher = new PasswordHasher();
$hash = $hasher->hash('my-password');
check($hash !== 'my-password', 'Le mot de passe doit être haché.');
check($hasher->verify('my-password', $hash), 'Le bon mot de passe doit être accepté.');
check(!$hasher->verify('wrong', $hash), 'Un mauvais mot de passe doit être refusé.');

echo "DTO, validation et hachage : OK\n";
