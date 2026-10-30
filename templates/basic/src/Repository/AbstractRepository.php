<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

/** Classe de base pédagogique ; chaque repository concret écrit ses requêtes SQL. */
abstract class AbstractRepository
{
    public function __construct(protected PDO $pdo) {}
}
