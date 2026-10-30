<?php

namespace App\Repository;

use App\Entity\Entity;
use App\Repository\AbstractRepository;
use App\Entity\User;
use Override;
use PDO;

final class UserRepository extends AbstractRepository
{
    public function __construct(PDO $connect)
    {
        return parent::__construct($connect);
    }

    #[Override]
    public function find(int $id): ?User
    {
        $stmt = $this->connect->prepare(
            'SELECT * FROM `user` WHERE id_user = ?'
        );
        $stmt->execute([$id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data === false ? null : User::hydrate($data);
    }

    #[Override]
    public function findAll(): array
    {
        $sql = <<<SQL
            SELECT u.id_user, u.firstname, u.lastname, u.email, 
            u.img_profil FROM `user` AS u ORDER BY u.id_user
            SQL;
        try {
            $users = $this->connect
                ->query($sql)
                ->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $users ?? [];
    }

    #[Override]
    public function create(Entity $entity): ?User
    {
        if (!$entity instanceof User) {
            throw new \InvalidArgumentException('UserRepository attend une entité User.');
        }

        $sql = <<<SQL
            INSERT INTO `user`(firstname, lastname, email, hash_password, created_at,
            img_profil, `grant`) VALUES (?,?,?,?,?,?,?)
            SQL;

        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute([
                $entity->getFirstname(),
                $entity->getLastname(),
                $entity->getEmail(),
                $entity->getHashPassword(),
                $entity->getCreatedAt()->format('Y-m-d H:i:s'),
                $entity->getImgProfil(),
                $entity->getGrant(),
            ]);

            $entity->setId((int) $this->connect->lastInsertId());
            return $entity;
        } catch (\PDOException $e) {
            // Laisser le service distinguer échec et succès sans afficher une erreur SQL.
            return null;
        }
    }

    public function findByEmail(string $email): ?User
    {
        $sql = <<<SQL
            SELECT u.id_user, u.firstname, u.lastname, u.email,
                   u.hash_password, u.created_at, u.updated_at,
                   u.img_profil, u.`grant`
            FROM `user` AS u
            WHERE u.email = ?
            SQL;

        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data === false) {
            return null;
        }

        $user = User::hydrate($data);
        $user->setId((int) $data['id_user']);
        return $user;
    }
}
