<?php

namespace App\Entity;

use App\Entity\Entity;
use Mithridatem\Validation\Attributes\Email;
use Mithridatem\Validation\Attributes\Length;
use Mithridatem\Validation\Attributes\NotBlank;

class User implements Entity
{
    private ?int $id = null;
    #[NotBlank]
    #[Length(min: 2, max: 50)]
    private ?string $firstname;
    #[NotBlank]
    #[Length(min: 2, max: 50)]
    private ?string $lastname;
    #[NotBlank]
    #[Email]
    private ?string $email;
    #[NotBlank]
    #[Length(min: 4, max: 50)]
    private ?string $hashPassword;
    private ?string $grant = null;
    private ?string $imgProfil = null;
    private ?\DateTimeImmutable $createdAt = null;
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        ?string $firstname,
        ?string $lastname,
        ?string $email,
        ?string $hashPassword
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->hashPassword = $hashPassword;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getHashPassword(): ?string
    {
        return $this->hashPassword;
    }

    public function setHashPassword(?string $hashPassword): self
    {
        $this->hashPassword = $hashPassword;
        return $this;
    }

    public function getGrant(): ?string
    {
        return $this->grant;
    }

    public function setGrant(?string $grant): self
    {
        $this->grant = $grant;
        return $this;
    }

    public function getImgProfil(): ?string
    {
        return $this->imgProfil;
    }

    public function setImgProfil(?string $imgProfil): self
    {
        $this->imgProfil = $imgProfil;
        return $this;
    }


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function hashPassword(): void
    {
        $this->hashPassword = password_hash(
            $this->hashPassword,
            PASSWORD_DEFAULT
        );
    }

    public function passwordVerify(string $clearPassword): bool
    {
        return password_verify(
            $clearPassword,
            $this->hashPassword
        );
    }

    public static function hydrate(array $data): self
    {
        $user = new self(
            $data['firstname'] ?? null,
            $data['lastname'] ?? null,
            $data['email'] ?? null,
            $data['hash_password'] ?? null
        );

        if (isset($data['id_user'])) {
            $user->setId((int) $data['id_user']);
        }

        $user->setGrant($data['grant'] ?? null);
        $user->setImgProfil($data['img_profil'] ?? null);

        if (!empty($data['created_at'])) {
            $user->setCreatedAt(new \DateTimeImmutable($data['created_at']));
        }

        if (!empty($data['updated_at'])) {
            $user->setUpdatedAt(new \DateTimeImmutable($data['updated_at']));
        }

        return $user;
    }
}
