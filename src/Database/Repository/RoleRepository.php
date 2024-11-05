<?php

namespace MxRoleManager\Database\Repository;

use MxRoleManager\Config\ConfigLoader;
use MxRoleManager\Model\Role;

class RoleRepository
{
    private static ?RoleRepository $instance = null;
    private \PDO $pdo;
    private string $targetTableName;

    private function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->targetTableName = ConfigLoader::getDatabaseTargetTable();
    }

    public static function getInstance(\PDO $pdo) : RoleRepository
    {
        if(self::$instance == null)
        {
            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    public function getRoleById(string $roleId) : ?Role
    {
        $query = "SELECT r.* FROM roles r WHERE r.id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':id' => $roleId]);

        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        $role = $data ? new Role() : null;
        $role?->hydrate($data);
        return $role;
    }

    public function getAllRoles() : array
    {
        $roles = [];

        $query = "SELECT r.* FROM roles r ";

        $results = $this->pdo->query($query, \PDO::FETCH_ASSOC)->fetchAll();
        foreach ($results as $result)
        {
            $role = new Role();
            $role->hydrate($result);
            $roles[] = $role;
        }

        return $roles;
    }

    public function getRolesByTarget(string $targetId) : array
    {
        $roles = [];

        $query = "SELECT r.* FROM roles r ";
        $query .= "INNER JOIN roles_{$this->targetTableName} rt ON rt.target_id = :id AND r.id = rt.role_id";

        $statement = $this->pdo->prepare($query);
        $statement->execute([':id' => $targetId]);

        while($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            $role = new Role();
            $role->hydrate($row);
            $roles[] = $role;
        }

        return $roles;
    }

    public function removeRoleFromTarget(Role $role, string $targetId) : bool
    {
        $roleId = $role->getId();
        $query = "DELETE FROM roles_{$this->targetTableName} WHERE role_id = :role_id AND target_id = :target_id";
        $statement = $this->pdo->prepare($query);
        return $statement->execute([
            'role_id' => $roleId,
            'target_id' => $targetId
        ]);
    }

    public function persistRole(Role $role) : bool
    {
        $query = "INSERT INTO roles(name, description, created_at) VALUES(:name, :description, NOW())";
        $statement = $this->pdo->prepare($query);
        return $statement->execute([
            'name' => $role->getName(),
            'description' => $role->getDescription()
        ]);
    }
}