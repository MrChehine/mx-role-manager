<?php

namespace MxRoleManager;

use MxRoleManager\Config\ConfigManager;
use MxRoleManager\Config\Handler\ConfigHandlerFactory;
use MxRoleManager\Database\Connection;
use MxRoleManager\Database\Repository\PermissionRepository;
use MxRoleManager\Database\Repository\RoleManagerRepository;
use MxRoleManager\Database\Repository\RoleRepository;
use MxRoleManager\Model\Permission;
use MxRoleManager\Model\Role;
use mysql_xdevapi\Session;
use PDO;

class RoleManager
{

    private RoleManagerRepository $roleManagerRepository;
    private PermissionRepository $permissionRepository;
    private RoleRepository $roleRepository;
    private static RoleManager $instance;

    /**
     * @param string|null $configFilePath
     * @param string|null $dotEnfFilePath
     */
    public function __construct(?string $configFilePath = null, ?string $dotEnfFilePath = null)
    {
        $configurationManager = new ConfigManager();
        $configurationManager->addConfigHandler(ConfigHandlerFactory::createEnvHandler($dotEnfFilePath));
        $configurationManager->addConfigHandler(ConfigHandlerFactory::createPHPFileHandler($configFilePath));
        $configurationManager->flushConfigurationsToLoader();

        $pdo = Connection::getPdo();
        $this->roleManagerRepository = new RoleManagerRepository($pdo);
        $this->permissionRepository = PermissionRepository::getInstance($pdo);
        $this->roleRepository = RoleRepository::getInstance($pdo);

        self::$instance = $this;
    }

    public function getRoleById(string $roleId) : Role
    {
        return $this->roleRepository->getRoleById($roleId);
    }

    public function getAllRoles() : array
    {
        return $this->roleRepository->getAllRoles();
    }

    public function getRolesByTarget(string $targetId) : array
    {
        return $this->roleRepository->getRolesByTarget($targetId);
    }

    public function getPermissionById(string $permissionId) : Permission
    {
        return $this->permissionRepository->getPermissionById($permissionId);
    }

    public function getPermissionsByTarget(string $targetId) : array
    {
        return $this->permissionRepository->getPermissionsByTarget($targetId);
    }

    public function getPermissionsByRole(Role $role) : array
    {
        return $this->permissionRepository->getPermissionsByRole($role);
    }

    public function getPermissionsByClass(string $className) : array
    {
        return $this->permissionRepository->getPermissionsByClass($className);
    }

    public function removePermissionFromRole(Permission $permission, Role $role) : bool
    {
        return $this->roleManagerRepository->removePermissionFromRole($permission, $role);
    }

    public function getControlledClasses() : array
    {
        return $this->roleManagerRepository->getControlledClasses();
    }

    public function persistRole(Role $role) : bool
    {
        return $this->roleRepository->persistRole($role);
    }

    public function addPermissionToRole(Permission $permission, Role $role) : bool
    {
        return $this->roleManagerRepository->addPermissionToRole($permission, $role);
    }

    public function addRoleToTarget(Role $role, string $targetId) : bool
    {
        return $this->roleManagerRepository->addRoleToTarget($role, $targetId);
    }

    public function removeRoleFromTarget(Role $role, string $targetId) : bool
    {
        return $this->roleRepository->removeRoleFromTarget($role, $targetId);
    }

    public static function isPermitted(int $targetId, ?string $className = null, ?string $methodName = null) : bool
    {
        $className = debug_backtrace()[1]['class'] ?? '';
        $methodName = debug_backtrace()[1]['function'] ?? '';

        $permissionsRepository = self::$instance->permissionRepository;
        $permissions = $permissionsRepository->getPermissionsByTarget($targetId);

        foreach($permissions as $permission)
        {
            if($permission->getClassName() == $className && $permission->getMethodName() == $methodName)
            {
                return true;
            }
        }
        return false;
    }

}