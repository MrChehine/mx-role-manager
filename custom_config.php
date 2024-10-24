<?php
return [
    'DB_USER' => 'root',
    'permissions' => [
        \MxRoleManager\RoleManager::class => [
            [
                'name' => 'edit',
                'description' => 'This permission is for updating roles',
                'method' => 'updateRole'
            ],
            [
                'name' => 'delete',
                'description' => 'This permission is for deleting roles',
                'method' => 'deleteRole'
            ]
        ],
        \MxRoleManager\Model\Permission::class => [
            [
                'name' => 'write',
                'description' => 'write a description',
                'method' => 'addPost'
            ],
            [
                'name' => 'approval',
                'description' => 'approve a Post',
                'method' => 'approvePosts'
            ],
            [
                'name' => 'reviewer',
                'description' => 'review a Post',
                'method' => 'review'
            ]
        ]
    ]
];