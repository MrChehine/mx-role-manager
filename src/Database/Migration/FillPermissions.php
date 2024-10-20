<?php

namespace MxRoleManager\Database\Migration;

use MxRoleManager\CLI\FillPermissionsCommand;
use MxRoleManager\Config\ConfigLoader;
use MxRoleManager\Database\Connection;
use MxRoleManager\Model\Permission;

class FillPermissions
{
    public static function run(FillPermissionsCommand $command) : void
    {
        $basePath = dirname(__DIR__);
        $pdo = Connection::getPdo();

        $permissionsConfig = ConfigLoader::getPermissionsConfig();
        foreach($permissionsConfig as $className => $configurations)
        {
            $permission = new Permission();
            $permission->setClassName($className);
            $permission->setMethodName($configurations['method'] ?? '');
            $permission->setName($configurations['name'] ?? '');
            $permission->setDescription($configurations['description'] ?? '');
            //$permission->setCreatedAt(new \DateTime('now'));
            //$permission->setUpdatedAt(null);

            $query = "INSERT INTO permissions(name,description,class_name,method_name,created_at) VALUES (:name, :description, :class_name, :method_name, now())";
            $statement = $pdo->prepare($query);
            $statement->execute([
                'name' => $permission->getName(),
                'description' => $permission->getDescription(),
                'class_name' => $permission->getClassName(),
                'method_name' => $permission->getMethodName()
            ]);
        }
    }
}