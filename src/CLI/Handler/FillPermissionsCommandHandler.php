<?php

namespace MxRoleManager\CLI\Handler;

use MxRoleManager\CLI\AbstractCommand;
use MxRoleManager\CLI\FillPermissionsCommand;
use MxRoleManager\Database\Migration\FillPermissions;

class FillPermissionsCommandHandler extends AbstractCommandHandler
{
    private FillPermissions $migration;

    public function __construct(FillPermissions $migration)
    {
        $this->migration = $migration;
    }

    public function handle(AbstractCommand $command) : void
    {
        $this->migration->run($command);
    }

}