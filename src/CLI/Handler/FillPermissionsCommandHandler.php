<?php

namespace MxRoleManager\CLI\Handler;

use MxRoleManager\CLI\FillPermissionsCommand;
use MxRoleManager\Database\Migration\FillPermissions;

class FillPermissionsCommandHandler
{

    private $migration;

    public function __construct(FillPermissions $migration)
    {
        $this->migration = $migration;
    }

    public function handle(FillPermissionsCommand $command)
    {
        $this->migration->run($command);
    }

}