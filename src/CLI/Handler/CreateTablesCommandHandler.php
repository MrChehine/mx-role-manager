<?php

namespace MxRoleManager\CLI\Handler;

use MxRoleManager\CLI\CreateTablesCommand;
use MxRoleManager\Database\Migration\CreateTables;

class CreateTablesCommandHandler
{
    private $migration;

    public function __construct(CreateTables $migration)
    {
        $this->migration = $migration;
    }

    public function handle(CreateTablesCommand $command)
    {
        $tables = $command->getTables();

        // Call migration logic to create the specified tables
        $this->migration->run($tables);
    }

}