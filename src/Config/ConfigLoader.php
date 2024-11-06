<?php

namespace MxRoleManager\Config;

class ConfigLoader
{
    private static array $configurations;
    private static string $cacheFile = __DIR__ . '/cache/treated_permissions.json';

    public static function setConfigurations(array $configurations) : void
    {
        self::$configurations = $configurations;
    }

    public static function getDatabaseHost() : string
    {
        return self::$configurations['DB_HOST'] ?? '';
    }

    public static function getDatabasePort() : string
    {
        return self::$configurations['DB_PORT'] ?? '';
    }

    public static function getDatabaseName() : string
    {
        return self::$configurations['DB_NAME'] ?? '';
    }

    public static function getDatabaseUsername() : string
    {
        return self::$configurations['DB_USER'] ?? '';
    }

    public static function getDatabasePassword() : string
    {
        return self::$configurations['DB_PASS'] ?? '';
    }

    public static function getDatabaseTargetTable() : ?string
    {
        return self::$configurations['DB_TARGET_TABLE'] ?? 'targets';
    }

    public static function getPermissionsConfig() : array
    {
        return self::$configurations['permissions'] ?? [];
    }

    public static function getCachedConfig() : array
    {
        return json_decode(file_get_contents(self::$cacheFile), true);
    }

    public static function clearPermissionsConfigCache() : void
    {
        file_put_contents(self::$cacheFile, json_encode([], JSON_PRETTY_PRINT));
    }

    public static function getFilterData() : array
    {
        $matchedData = [];
        $updatedData = [];
        $newData = [];

        $cachedData = self::getCachedConfig();
        $configData = self::getPermissionsConfig();

        foreach ($configData as $class => $permissions) {
            if(!isset($cachedData[$class]))
            {
                $newData[$class] = $permissions;
            }
            if(isset($cachedData[$class]))
            {
                foreach ($permissions as $key => $permission)
                {
                    if(isset($cachedData[$class][$key]))
                    {
                        if($cachedData[$class][$key] !== $permission)
                        {
                            $updatedData[$class][$key] = $permission;
                        }
                        else
                        {
                            $matchedData[$class][$key] = $permission;
                        }
                    }
                    else
                    {
                        $newData[$class][$key] = $permission;
                    }
                }
            }
        }

        return [
            'matchedData' => $matchedData,
            'updatedData' => $updatedData,
            'newData'     => $newData
        ];

    }

    public static function addPermissionsConfigToCache(array $excludedPermissions = []) : void
    {
        $permissionsConfig = self::getPermissionsConfig();
        $cachedConfig = self::getCachedConfig();
        foreach ($excludedPermissions as $className => $excludedPermission)
        {
            foreach ($excludedPermission as $index => $value)
            {
                $permissionsConfig[$className][$index] = $cachedConfig[$className][$index];
            }
        }
        file_put_contents(self::$cacheFile, json_encode($permissionsConfig, JSON_PRETTY_PRINT));
    }
}