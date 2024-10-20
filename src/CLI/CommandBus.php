<?php

namespace MxRoleManager\CLI;

class CommandBus
{
    private array $handlers = [];

    public function registerHandler(string $commandClass, $handler)
    {
        $this->handlers[$commandClass] = $handler;
    }

    public function handle($command)
    {
        $commandClass = get_class($command);
        if (!isset($this->handlers[$commandClass])) {
            throw new \Exception("No handler registered for command: " . $commandClass);
        }

        return $this->handlers[$commandClass]->handle($command);
    }

}