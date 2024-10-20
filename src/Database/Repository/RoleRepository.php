<?php

namespace MxRoleManager\Database\Repository;

use MxRoleManager\Config\ConfigLoader;
use MxRoleManager\Model\Role;

class RoleRepository
{
    private \PDO $pdo;
    private string $targetTableName;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->targetTableName = ConfigLoader::getDatabaseTargetTable();
    }

    public function getAllRoles() : array
    {
        $roles = [];

        $query = "SELECT r.* FROM roles r ";

        $results = $this->pdo->query($query, \PDO::FETCH_ASSOC)->fetchAll();
        foreach ($results as $result)
        {
            $roles[] = new Role($result);
        }

        return $roles;
    }

    public function getRolesForTarget(string $targetId) : array
    {
        $roles = [];

        $query = "SELECT r.* FROM roles r ";
        $query .= "INNER JOIN roles_{$this->targetTableName} rt ON rt.target_id = :id AND r.id = rt.role_id";

        $statement = $this->pdo->prepare($query);
        $statement->execute([':id' => $targetId]);

        while($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            $role = new Role($row);
            $roles[] = $role;
        }

        return $roles;
    }
}