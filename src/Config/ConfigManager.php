<?php

namespace MxRoleManager\Config;

use MxRoleManager\Config\Handler\ConfigHandlerInterface;

class ConfigManager
{
    /**
     * @var ConfigHandlerInterface[]
     */
    private array $configHandlers;

    /**
     * @param ConfigHandlerInterface $configHandler
     */
    public function addConfigHandler(ConfigHandlerInterface $configHandler): void
    {
        $this->configHandlers[] = $configHandler;
    }

    public function getParameter(string $parameterName) : ?string
    {
        foreach($this->configHandlers as $configHandler)
        {
            if($configHandler->getParameter($parameterName) != null)
            {
                return $configHandler->getParameter($parameterName);
            }
        }
        return null;
    }

    public function getAllConfigurationParameters() : array
    {
        $parameters = [];
        foreach($this->configHandlers as $configHandler)
        {
            $parameters = array_merge($parameters, $configHandler->getAllConfigurationParameters());
        }
        return $parameters;
    }

    public function flushConfigurationsToLoader() : void
    {
        ConfigLoader::setConfigurations($this->getAllConfigurationParameters());
    }

}