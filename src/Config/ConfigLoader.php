<?php

namespace MxRoleManager\Config;

class ConfigLoader
{

    private static array $configurations;

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
        return self::$configurations['DB_TARGET_TABLE'] ?? null;
    }

    public static function getPermissionsConfig() : array
    {
        return self::$configurations['permissions'] ?? [];
    }

}