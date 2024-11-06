<?php

namespace MxRoleManager\Config\Handler;

class EnvConfigHandler implements ConfigHandlerInterface
{

    public function __construct(?string $pathToDotEnv)
    {
        if($pathToDotEnv != null)
        {
            $env = \Dotenv\Dotenv::createImmutable($pathToDotEnv);
            $env->load();
        }
    }

    function getParameter(string $parameterName): ?string
    {
        return $_ENV[$parameterName] ?? null;
    }

    function getAllConfigurationParameters(): array
    {
        return $_ENV;
    }
}