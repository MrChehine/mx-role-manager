<?php

namespace MxRoleManager\CLI\Handler;

use MxRoleManager\CLI\AbstractCommand;

abstract class AbstractCommandHandler
{
    public abstract function handle(AbstractCommand $command) : void;
}