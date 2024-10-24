<?php

namespace MxRoleManager\Database\Migration;

use MxRoleManager\CLI\AbstractCommand;
use MxRoleManager\CLI\FillPermissionsCommand;
use MxRoleManager\Config\ConfigLoader;
use MxRoleManager\Database\Connection;
use MxRoleManager\Database\Repository\PermissionRepository;
use MxRoleManager\Model\Permission;

class FillPermissions
{
    /**
     * @param FillPermissionsCommand|null $command
     * @return void
     */
    public static function run(AbstractCommand $command = null) : void
    {
        $pdo = Connection::getPdo();
        $permissionRepository = PermissionRepository::getInstance($pdo);
        $isUpdate = $command != null && $command->isUpdate();
        $isClearCache = $command != null && $command->isClearCache();
        $isTruncate = $command != null && $command->isTruncate();

        if($isClearCache)
        {
            ConfigLoader::clearPermissionsConfigCache();
        }
        if($isTruncate)
        {
            ConfigLoader::clearPermissionsConfigCache();
            $permissionRepository->truncatePermissions();
        }
        $permissionsConfig = ConfigLoader::getFilterData();
        foreach($permissionsConfig['newData'] as $className => $configurations)
        {
            foreach ($configurations as $configuration)
            {
                $permission = self::createPermissionFromConfiguration($className, $configuration);
                $permissionRepository->persistPermission($permission);
            }
        }
        if($isUpdate)
        {
            foreach($permissionsConfig['updatedData'] as $className => $configurations)
            {
                foreach($configurations as $key => $configuration)
                {
                    $oldPermissionConfig = ConfigLoader::getCachedConfig()[$className][$key];
                    $oldPermission = self::createPermissionFromConfiguration($className, $oldPermissionConfig);
                    $newPermission = self::createPermissionFromConfiguration($className, $configuration);
                    $permissionRepository->updatePermission($oldPermission, $newPermission);
                }
            }
        }
        ConfigLoader::addPermissionsConfigToCache($isUpdate ? [] : $permissionsConfig['updatedData']);
    }

    private static function createPermissionFromConfiguration(string $className, array $configuration) : Permission
    {
        $permissionName = $configuration['name'] ?? '';
        $permissionDescription = $configuration['description'] ?? '';
        $permissionMethodName = $configuration['method'] ?? '';
        return new Permission($permissionName, $permissionDescription, $className, $permissionMethodName);
    }
}