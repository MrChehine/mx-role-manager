<?php

namespace MxRoleManager\CLI;

use Exception;
use MxRoleManager\CLI\Handler\AbstractCommandHandler;

class CommandBus
{
    /**
     * @var AbstractCommandHandler[]
     */
    private array $handlers = [];

    public function registerHandler(string $commandClass, AbstractCommandHandler $handler) : void
    {
        $this->handlers[$commandClass] = $handler;
    }

    /**
     * @throws Exception
     */
    public function handle(AbstractCommand $command) : void
    {
        $commandClass = get_class($command);
        if (!isset($this->handlers[$commandClass])) {
            throw new Exception("No handler registered for command: " . $commandClass);
        }
        $this->handlers[$commandClass]->handle($command);
    }

}