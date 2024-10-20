<?php

namespace MxRoleManager\Config\Handler;

class FileConfigHandler implements ConfigHandlerInterface
{

    private array $configurations;

    public function __construct(string $configFile)
    {
        if(file_exists($configFile))
        {
            $this->configurations = include $configFile;
        }
        else {
            $this->configurations = [];
        }
    }

    function getParameter(string $parameterName): ?string
    {
        return $this->configurations[$parameterName] ?? null;
    }

    function getAllConfigurationParameters(): array
    {
        return $this->configurations;
    }
}