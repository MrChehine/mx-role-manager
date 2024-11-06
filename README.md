# RoleManager
`RoleManager` is a PHP-based role and permission management library designed to facilitate role-based access control (RBAC) in applications. It provides robust functionality for defining, assigning, and querying roles and permissions for different targets, allowing developers to control access in a modular and scalable manner.

## Features
- Retrieve specific roles or permissions by ID.
- Fetch roles and permissions associated with a target (user or entity).
- Query permissions associated with specific classes or methods.
- Assign or remove roles and permissions for targets.
- Persist roles in storage and manage relationships between roles and permissions.
- Check access permissions for specific classes and methods dynamically.

## Installation
Install via `composer`:
```bash
composer require chehine/role-manager
```

## Command-Line Interface (CLI)
RoleManager includes CLI commands to automate essential setup tasks. Commands must be run from the directory containing the `.env` file, which should contain the following database configuration keys:
```dotenv
DB_HOST=
DB_PORT=
DB_NAME=
DB_USER=
DB_PASS=

# Optional:
DB_TARGET_TABLE=users
```

Available Commands
1. vendor/bin/role-manager create-tables
   * Creates necessary database tables for managing roles and permissions.

2. vendor/bin/role-manager fill-permissions
      * Fills the permissions table based on configuration from a PHP file.
   
          #### Options:
          * **--config-file**="path/to/config.php": Required. Specifies the path to the configuration file containing permission definitions. Without this file, permissions will not be inserted into the database.
          * **--update**: Optional. Updates any entries in the database that match entries in the configuration file but have modified values.
          * **--truncate**: Optional. Deletes all permissions from the database.
          * **--clear-cache**: Optional. Clears cached permission data to resolve conflicts that might occur between database and cache.

**_Note_**: The permissions configuration file should follow this format:
```php
return [
    'permissions' => [
        \Namespace\Class1::class => [
            [
                'name' => 'view',
                'description' => 'View class1 details',
                'method' => 'viewDetails'
            ],
            [
                'name' => 'edit',
                'description' => 'Edit class1',
                'method' => 'editClass1'
            ]
        ],
        \Namespace\Class2::class => [
            [
                'name' => 'approval',
                'description' => 'Approve a post',
                'method' => 'approvePosts'
            ]
        ]
    ]
];
```

## Code Usage
### Configuration & Initialization
You can configure the library with a .env file and a PHP configuration file that defines database credentials and permissions.

Initialize RoleManager with paths to these files for setup.
```php 
$roleManager = new RoleManager('/path/to/config.php', '/path/to/.env'); 
```

### Example Usages
* Creating a new role
```php
$role = new Role();
$role->setName('Editor');
$role->setDescription('Role with permissions to edit content');

// Persist the role to the database
$roleManager->persistRole($role);
```
The `persistRole` method will save the new role to the database, making it available for assigning permissions and associating with targets.

* Retrieve a Role by ID 
```php 
$role = $roleManager->getRoleById('role_id'); 
```
* Get All Roles 
```php 
$roles = $roleManager->getAllRoles(); 
```
* Fetch Permissions for a Target 
```php 
$permissions = $roleManager->getPermissionsByTarget('target_id'); 
```
* Add Permission to Role 
```php 
$permission = $roleManager->getPermissionById('permission_id'); 
$role = $roleManager->getRoleById('role_id');
$roleManager->addPermissionToRole($permission, $role); 
```
* Check Permission for a Class and Method 
```php 
if (RoleManager::isPermitted($targetId, MyClass::class, 'methodName')) 
{ 
    // Permission granted 
} 
```
**_Note_**: `isPermitted` can automatically detect the calling class and method. If invoked within a class-method combination defined as a permission, it will match that combination without requiring parameters.

Example:
```php 
<?php
namespace Namespace

class Class1
{
    //...
    public function viewDetails() : void
    {
        if (RoleManager::isPermitted($targetId)) 
        { 
            // Permission granted (The permission is defined in the configurations file)
        } 
    }
    //...
}
?>
```

## License
MIT License

Copyright (c) [Chehine Ammari] [2024]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES, OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
