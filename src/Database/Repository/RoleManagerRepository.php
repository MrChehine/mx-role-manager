<?php

namespace MxRoleManager\Database\Repository;

class RoleManagerRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getControlledClasses() : array
    {
        $query = $this->pdo->query("SELECT DISTINCT class_name FROM permissions");
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

}