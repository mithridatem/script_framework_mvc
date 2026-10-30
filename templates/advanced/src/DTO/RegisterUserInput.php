<?php

declare(strict_types=1);

namespace App\DTO;

use Mithridatem\Validation\Attributes\Email;
use Mithridatem\Validation\Attributes\Length;
use Mithridatem\Validation\Attributes\NotBlank;

/**
 * Données propres au cas d'utilisation "inscrire un utilisateur".
 * La confirmation du mot de passe n'appartient pas à l'entité persistée.
 */
final readonly class RegisterUserInput
{
    public function __construct(
        #[NotBlank]
        #[Length(min: 2, max: 50)]
        public ?string $firstname,
        #[NotBlank]
        #[Length(min: 2, max: 50)]
        public ?string $lastname,
        #[NotBlank]
        #[Email]
        public ?string $email,
        #[NotBlank]
        #[Length(min: 4, max: 50)]
        public ?string $password,
        #[NotBlank]
        public ?string $confirmPassword,
    ) {}

    /**
     * Conversion défensive : un champ de formulaire peut être un tableau.
     * Ne jamais modifier silencieusement les caractères du mot de passe.
     */
    public static function fromArray(array $data): self
    {
        $text = static function (mixed $value): ?string {
            return is_string($value) ? trim($value) : null;
        };
        $password = static function (mixed $value): ?string {
            return is_string($value) ? $value : null;
        };

        return new self(
            $text($data['firstname'] ?? null),
            $text($data['lastname'] ?? null),
            $text($data['email'] ?? null),
            $password($data['password'] ?? null),
            $password($data['confirm_password'] ?? null),
        );
    }
}
