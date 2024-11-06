<?php

namespace MxRoleManager\Database\Repository;

use MxRoleManager\Config\ConfigLoader;
use MxRoleManager\Model\Permission;
use MxRoleManager\Model\Role;

class RoleManagerRepository
{
    private \PDO $pdo;
    private string $targetTableName;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->targetTableName = ConfigLoader::getDatabaseTargetTable();
    }

    public function getControlledClasses() : array
    {
        $query = $this->pdo->query("SELECT DISTINCT class_name FROM permissions");
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function addPermissionToRole(Permission $permission, Role $role) : bool
    {
        $permissionId = $permission->getId();
        $roleId = $role->getId();
        $query = "INSERT INTO roles_permissions(role_id, permission_id, created_at) VALUES(:role_id, :permission_id, NOW())";
        $statement = $this->pdo->prepare($query);
        return $statement->execute([
            'role_id' => $roleId,
            'permission_id' => $permissionId
        ]);
    }

    public function removePermissionFromRole(Permission $permission, Role $role) : bool
    {
        $permissionId = $permission->getId();
        $roleId = $role->getId();
        $query = "DELETE FROM roles_permissions WHERE permission_id = :permission_id AND role_id = :role_id";
        $statement = $this->pdo->prepare($query);
        return $statement->execute([
            'permission_id' => $permissionId,
            'role_id' => $roleId
        ]);
    }

    public function addRoleToTarget(Role $role, string $targetId) : bool
    {
        $roleId = $role->getId();
        $query = "INSERT INTO roles_{$this->targetTableName}(role_id, target_id, created_at) VALUES(:role_id, :target_id, NOW())";

        $statement = $this->pdo->prepare($query);
        return $statement->execute([
            'role_id' => $roleId,
            'target_id' => $targetId
        ]);
    }

}