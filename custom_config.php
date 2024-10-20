<?php
return [
    'DB_USER' => 'root',
    'permissions' => [
        \MxRoleManager\RoleManager::class => [
            'name' => 'edit',
            'description' => 'This permission is for editing roles',
            'method' => 'updateRole'
        ],
    ]
];