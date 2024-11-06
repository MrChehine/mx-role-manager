<?php

namespace MxRoleManager\CLI\Handler;

use MxRoleManager\CLI\AbstractCommand;
use MxRoleManager\CLI\CreateTablesCommand;
use MxRoleManager\Database\Migration\CreateTables;

class CreateTablesCommandHandler extends AbstractCommandHandler
{
    private CreateTables $migration;

    public function __construct(CreateTables $migration)
    {
        $this->migration = $migration;
    }

    public function handle(AbstractCommand $command = null) : void
    {
        // Call migration logic to create the specified tables
        $this->migration->run();
    }

}