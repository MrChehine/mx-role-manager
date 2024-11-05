<?php

use MxRoleManager\Config\Handler\ConfigHandlerFactory;
use MxRoleManager\Database\Connection;
use MxRoleManager\RoleManager;

require 'vendor/autoload.php';

//Command:
// * docker-compose run --rm app php /app/sandbox.php
// OR
// * docker run -it --rm --name phpcli -v $(pwd):/app -w /app php:8.2-cli-alpine php sandbox.php
// OR
// * docker run -it --rm --name phpcli -v $(pwd):/app -w /app mxrolemanager-app:latest php sandbox.php
// OR
// * make sandbox

/*
$phpinfo_html = fopen(__DIR__.'/phpinfo.html','w');
ob_start();
phpinfo();
$phpinfo = ob_get_clean();
fwrite($phpinfo_html, $phpinfo);
fclose($phpinfo_html);
die();
*/

$env = \Dotenv\Dotenv::createImmutable('/app');
$env->load();
//var_dump($_ENV);
/*echo dirname(__DIR__);
echo getenv('DB_HOST') ?? 'null';
echo $_ENV['DB_HOST'];
echo "\n
";*/

//$pdo = Connection::getPdo();

//var_dump($pdo);

$role_manager = new RoleManager(__DIR__.'/custom_config.php', '/app');

//$configurationManager = new \MxRoleManager\Config\ConfigManager();
//$configurationManager->addConfigHandler(ConfigHandlerFactory::createEnvHandler('/app'));
//$configurationManager->addConfigHandler(ConfigHandlerFactory::createPHPFileHandler(__DIR__.'/custom_config.php'));
//$databaseUsername = $configurationManager->getParameter('DB_USER');

//\MxRoleManager\Database\Migration\CreateTables::run();
//\MxRoleManager\Database\Migration\FillPermissions::run();
//var_dump($role_manager::getPermissionsForTarget(1)[0]->getDescription());
//var_dump($role_manager::getPermissionsForClass(RoleManager::class));
//var_dump($role_manager::getRolesForTarget(1));
//var_dump($role_manager::getControlledClasses());
//var_dump($role_manager::getPermissionsForClass($role_manager::getControlledClasses()[0]));
//var_dump($role_manager::getAllRoles());
//$role = $role_manager::getAllRoles()[1];
//$permission = $role_manager::getPermissionsForClass(RoleManager::class)[0];
//
//var_dump($role_manager::getPermissionsForRole($role));
//var_dump($role_manager::addPermissionToRole($permission, $role));

//var_dump(\MxRoleManager\Config\ConfigLoader::getFilterData());
//var_dump($role_manager::getPermissionsForClass(RoleManager::class));
//$approvalPermission = $role_manager::getPermissionsForClass(\MxRoleManager\Model\Permission::class)[1];
//$editPermission = $role_manager::getPermissionsForClass(RoleManager::class)[0];
//$deletePermission = $role_manager::getPermissionsForClass(RoleManager::class)[1];
//$role = $role_manager::getAllRoles()[0];

//$role_manager::addRoleToTarget($role, '1');
//$role_manager::addPermissionToRole($approvalPermission, $role);
//$role_manager::addPermissionToRole($editPermission, $role);
//$role_manager::addPermissionToRole($deletePermission, $role);
//var_dump($role_manager::getPermissionById(1));

//$permission = $role_manager::getPermissionById(4);
//$role = $role_manager::getRoleById(1);
//$role_manager::removePermissionFromRole($permission, $role);

//$role = $role_manager::getRoleById(1);
//$role_manager::addRoleToTarget($role, 1);
