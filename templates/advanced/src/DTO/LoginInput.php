<?php

declare(strict_types=1);

namespace App\DTO;

use Mithridatem\Validation\Attributes\Email;
use Mithridatem\Validation\Attributes\NotBlank;

final readonly class LoginInput
{
    public function __construct(
        #[NotBlank]
        #[Email]
        public ?string $email,
        #[NotBlank]
        public ?string $password,
    ) {}

    public static function fromArray(array $data): self
    {
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        return new self(
            is_string($email) ? trim($email) : null,
            is_string($password) ? $password : null,
        );
    }
}
