<?php

namespace MxRoleManager\CLI;

class CreateTablesCommand
{

    private array $tables;

    /**
     * @param array $tables - List of tables to create (e.g., ['roles', 'permissions']).
     */
    public function __construct(array $tables = [])
    {
        // If no specific tables are passed, create all tables by default
        $this->tables = !empty($tables) ? $tables : ['roles', 'permissions'];
    }

    /**
     * Get the tables to be created.
     *
     * @return array
     */
    public function getTables(): array
    {
        return $this->tables;
    }

}