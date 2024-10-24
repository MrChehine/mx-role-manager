<?php

namespace MxRoleManager\Config\Handler;

class ConfigHandlerFactory
{
    public static function createEnvHandler(?string $pathToDotEnv) : ConfigHandlerInterface
    {
        return new EnvConfigHandler($pathToDotEnv);
    }

    public static function createPHPFileHandler(?string $configFile): ConfigHandlerInterface
    {
        return new FileConfigHandler($configFile);
    }
}