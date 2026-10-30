<?php

namespace App\Repository;

use App\Entity\Entity;
use PDO;

abstract class AbstractRepository
{
    public function __construct(protected PDO $connect) {}

    /**
     * Méthode qui retourne une entity par son id si elle existe
     * @param int $id
     * @return ?Entity
     */
    abstract public function find(int $id): ?Entity;

    /**
     * Méthodes qui retourne la liste des Entity en BDD
     * @return array<Entity>
     */
    abstract public function findAll(): array;

    /**
     * Méthode qui ajoute une entité en BDD
     * @param Entity $entity Entity en entrée
     * @return ?Entity entité ajouté en BDD ou null
     */
    abstract public function create(Entity $entity): ?Entity;
}
