<?php

namespace MxRoleManager\Database\Repository;

use MxRoleManager\Config\ConfigLoader;
use MxRoleManager\Model\Permission;

class PermissionRepository
{

    private \PDO $pdo;
    private string $targetTableName;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->targetTableName = ConfigLoader::getDatabaseTargetTable();
    }

    public function getPermissionsForTarget(int $targetId) : array
    {
        $permissions = [];

        $query = "SELECT p.* FROM permissions p ";
        $query .= "INNER JOIN roles_{$this->targetTableName} rt ON rt.target_id = :id ";
        $query .= "INNER JOIN roles r ON r.id = rt.role_id ";
        $query .= "INNER JOIN roles_permissions rp ON rp.role_id=r.id AND p.id=rp.permission_id;";

        $statement = $this->pdo->prepare($query);
        $statement->execute([':id' => $targetId]);

        while($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            $permission = new Permission($row);
            $permissions[] = $permission;
        }

        return $permissions;
    }

    public function getPermissionsForClass(string $className) : array
    {
        $permissions = [];

        $query = "SELECT p.* FROM permissions p WHERE p.class_name = :class_name;";

        $statement = $this->pdo->prepare($query);
        $statement->execute([':class_name' => $className]);

        while($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            $permission = new Permission($row);
            $permissions[] = $permission;
        }

        return $permissions;
    }
}