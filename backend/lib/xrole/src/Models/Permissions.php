<?php

namespace Ximdex\Xrole\Models;

use Ximdex\Xrole\Contracts\PermissionsInterface;

class Permissions implements PermissionsInterface
{
    private $permissionCode = 0;

    /**
     * Constructs a new instance of the class with the given permissions.
     *
     * @param int $permissions The permissions to initialize the object with. Defaults to 0.
     */
    public function __construct($permissions = 0)
    {
        if (!is_int($permissions) || $permissions < 0) {
            throw new \InvalidArgumentException("Permissions must be a non-negative integer");
        }
        $this->permissionCode = $permissions;
    }

    /**
     * Checks if the given permission is present in the permission code.
     *
     * @param int $permission The permission to check.
     * @return bool Returns true if the permission is present, false otherwise.
     */
    public function hasPermission($permission)
    {
        return ($this->permissionCode & $permission) === $permission;
    }

    /**
     * Calculates the permission code from an array of permission constants.
     *
     * @param array $permissions An array of constants from PermissionConstants.
     * @return int The resulting permission code.
     */
    public static function calculatePermissionCode(array $permissions): int
    {
        $code = 0;
        foreach ($permissions as $permission) {
            if (!is_int($permission) || $permission < 0) {
                throw new \InvalidArgumentException("Each permission must be a valid non-negative integer.");
            }
            $code |= $permission;
        }
        return $code;
    }
}
