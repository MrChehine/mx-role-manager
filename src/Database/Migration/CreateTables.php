<?php

namespace MxRoleManager\Database\Migration;

use MxRoleManager\Config\ConfigLoader;
use MxRoleManager\Database\Connection;

class CreateTables
{

    public static function run() : void
    {
        $basePath = dirname(__DIR__);
        $pdo = Connection::getPdo();

        $createRolesTableSQL = file_get_contents($basePath."/sql/create_roles_table.sql");
        $pdo->exec($createRolesTableSQL);

        $createPermissionsTableSQL = file_get_contents($basePath."/sql/create_permissions_table.sql");
        $pdo->exec($createPermissionsTableSQL);

        $createRolesPermissionsTableSQL = file_get_contents($basePath."/sql/create_roles_permissions_table.sql");
        $pdo->exec($createRolesPermissionsTableSQL);

        $createRolesTargetsTableSQL = file_get_contents($basePath."/sql/create_roles_targets_table.sql");
        $targetTable = ConfigLoader::getDatabaseTargetTable();
        if($targetTable !== null && $targetTable !== 'targets')
        {
            //$createRolesTargetsTableSQL = str_replace("target_id", $targetTable.'_id', $createRolesTargetsTableSQL);
            $createRolesTargetsTableSQL = str_replace("roles_targets", 'roles_'.$targetTable, $createRolesTargetsTableSQL);
            $createRolesTargetsTableSQL = str_replace("fk_roles_targets_role_id", 'fk_roles_'.$targetTable.'_role_id', $createRolesTargetsTableSQL);

            $foreignKeyQuery = file_get_contents($basePath.'/sql/add_foreign_key_on_target_id.sql');
            $foreignKeyQuery = str_replace("roles_targets", 'roles_'.$targetTable, $foreignKeyQuery);
            $foreignKeyQuery = str_replace("targets(id)", $targetTable.'(id)', $foreignKeyQuery);

            $pdo->exec($createRolesTargetsTableSQL);
            $pdo->exec($foreignKeyQuery);
        } else
        {
            $pdo->exec($createRolesTargetsTableSQL);
        }

    }

}