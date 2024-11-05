<?php

namespace MxRoleManager\Database\Repository;

use MxRoleManager\Config\ConfigLoader;
use MxRoleManager\Model\Permission;
use MxRoleManager\Model\Role;

class PermissionRepository
{

    private static ?PermissionRepository $instance = null;
    private \PDO $pdo;
    private string $targetTableName;

    private function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->targetTableName = ConfigLoader::getDatabaseTargetTable();
    }

    public static function getInstance(\PDO $pdo) : PermissionRepository
    {
        if(self::$instance == null)
        {
            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    public function getPermissionById(string $permissionId) : ?Permission
    {
        $query = "SELECT p.* FROM permissions p WHERE p.id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':id' => $permissionId]);

        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        $permission = $data ? new Permission() : null;
        $permission?->hydrate($data);
        return $permission;
    }

    public function getPermissionsByRole(Role $role) : array
    {
        $permissions = [];
        $roleId = $role->getId();

        $query = "SELECT * FROM permissions p ";
        $query .= "INNER JOIN roles_permissions rp ON rp.role_id = :role_id AND rp.permission_id = p.id";
        $statement = $this->pdo->prepare($query);
        $statement->execute(['role_id' => $roleId]);

        while($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            $permission = new Permission();
            $permission->hydrate($row);
            $permissions[] = $permission;
        }

        return $permissions;
    }

    public function getPermissionsByTarget(string $targetId) : array
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
            $permission = new Permission();
            $permission->hydrate($row);
            $permissions[] = $permission;
        }

        return $permissions;
    }

    public function getPermissionsByClass(string $className) : array
    {
        $permissions = [];

        $query = "SELECT p.* FROM permissions p WHERE p.class_name = :class_name;";

        $statement = $this->pdo->prepare($query);
        $statement->execute([':class_name' => $className]);

        while($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            $permission = new Permission();
            $permission->hydrate($row);
            $permissions[] = $permission;
        }

        return $permissions;
    }

    public function persistPermission(Permission $permission) : bool
    {
        $query = "INSERT INTO permissions(name,description,class_name,method_name,created_at) VALUES (:name, :description, :class_name, :method_name, NOW())";
        $statement = $this->pdo->prepare($query);
        return $statement->execute([
            'name' => $permission->getName(),
            'description' => $permission->getDescription(),
            'class_name' => $permission->getClassName(),
            'method_name' => $permission->getMethodName()
        ]);
    }
    public function updatePermission(Permission $oldPermission, Permission $newPermission) : bool
    {
        $whereClause = " WHERE ";
        $bindValues = [
            'name' => $newPermission->getName(),
            'description' => $newPermission->getDescription(),
            'class_name' => $newPermission->getClassName(),
            'method_name' => $newPermission->getMethodName()
        ];
        if($oldPermission->getId() != null)
        {
            $whereClause .= "id = :id";
            $bindValues = array_merge(['id' => $oldPermission->getId()], $bindValues);
        }
        else{
            $whereClause .= "name = :old_name AND description = :old_description AND class_name = :old_class_name AND method_name = :old_method_name";
            $bindValues = array_merge([
                'old_name' => $oldPermission->getName(),
                'old_description' => $oldPermission->getDescription(),
                'old_class_name' => $oldPermission->getClassName(),
                'old_method_name' => $oldPermission->getMethodName(),
            ], $bindValues);
        }
        $query = "UPDATE permissions SET name = :name, description = :description, class_name = :class_name, method_name = :method_name, updated_at = NOW() {$whereClause}";
        $statement = $this->pdo->prepare($query);
        return $statement->execute($bindValues);
    }

    public function truncatePermissions() : void
    {
        $query = "SET FOREIGN_KEY_CHECKS = 0;";
        $query .= "DELETE FROM permissions;";
        $query .= "ALTER TABLE permissions AUTO_INCREMENT = 1;";
        $query .= "TRUNCATE TABLE permissions;";
        $query .= "SET FOREIGN_KEY_CHECKS = 1;";
        $this->pdo->exec($query);
    }
}