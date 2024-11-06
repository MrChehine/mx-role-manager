<?php

namespace MxRoleManager\Config\Handler;

interface ConfigHandlerInterface
{
    function getAllConfigurationParameters() : array;

    function getParameter(string $parameterName) : ?string;
}