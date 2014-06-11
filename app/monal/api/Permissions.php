<?php
namespace Monal\API;
/**
 * Permissions API.
 *
 * This providers a static interface to the systems Permissions API.
 *
 * @author  Arran Jacques
 */

use Monal\API;

class Permissions extends API
{
    /**
     * Return all permission sets added to the system.
     *
     * @return  Array
     */
    public static function permissionSets()
    {
        return self::systemInstance()->permissions->permissionSets();
    }

    /**
     * Add a new permission set to the system.
     *
     * @param   String
     * @param   String
     * @param   Array
     * @return  Void
     */
    public static function addPermissionSet($name, $slug, array $permissions = array())
    {
        self::systemInstance()->permissions->permissionSets($name, $slug, $permissions);
    }
}