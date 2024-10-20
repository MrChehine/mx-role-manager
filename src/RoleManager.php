<?php

namespace MxRoleManager;

use MxRoleManager\Config\ConfigManager;
use MxRoleManager\Config\Handler\ConfigHandlerFactory;
use MxRoleManager\Database\Connection;
use MxRoleManager\Database\Repository\PermissionRepository;
use MxRoleManager\Database\Repository\RoleManagerRepository;
use MxRoleManager\Database\Repository\RoleRepository;
use PDO;

class RoleManager
{

    private static RoleManagerRepository $roleManagerRepository;
    private static PermissionRepository $permissionRepository;
    private static RoleRepository $roleRepository;

    /**
     * @param string|null $configFilePath
     */
    public function __construct(?string $configFilePath)
    {
        $configurationManager = new ConfigManager();
        $configurationManager->addConfigHandler(ConfigHandlerFactory::createEnvHandler('/app'));
        $configurationManager->addConfigHandler(ConfigHandlerFactory::createPHPFileHandler($configFilePath));
        $configurationManager->flushConfigurationsToLoader();

        $pdo = Connection::getPdo();
        self::$roleManagerRepository = new RoleManagerRepository($pdo);
        self::$permissionRepository = new PermissionRepository($pdo);
        self::$roleRepository = new RoleRepository($pdo);
    }

    public static function getAllRoles() : array
    {
        return self::$roleRepository->getAllRoles();
    }

    public static function getRolesForTarget(string $targetId) : array
    {
        return self::$roleRepository->getRolesForTarget($targetId);
    }

    public static function getPermissionsForTarget(int $targetId) : array
    {
        return self::$permissionRepository->getPermissionsForTarget($targetId);
    }

    public static function getPermissionsForClass(string $className) : array
    {
        return self::$permissionRepository->getPermissionsForClass($className);
    }

    public static function getControlledClasses() : array
    {
        return self::$roleManagerRepository->getControlledClasses();
    }

    public static function isPermitted(int $targetId, ?string $className = null, ?string $methodName = null) : bool
    {
        $className = debug_backtrace()[1]['class'] ?? '';
        $methodName = debug_backtrace()[1]['function'] ?? '';

        $permissions = self::getPermissionsForTarget($targetId);

        foreach($permissions as $permission)
        {
            if($permission->getClassName() == $className && $permission->getMethodName() == $methodName)
            {
                return true;
            }
        }
        return false;
    }

    //temporary method for test
    public function updateRole() : void
    {
        var_dump(RoleManager::isPermitted(1));
    }

}