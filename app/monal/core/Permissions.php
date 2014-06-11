<?php
namespace Monal\Core;
/**
 * Permissions.
 *
 * This is Monal’s permissions API, which providers methods to read
 * and write permissions sets to and from the system.
 *
 * @author  Arran Jacques
 */

class Permissions
{
    /**
     * An array of permission sets added to the system.
     *
     * @var     Array
     */
    protected $permission_sets = array();

    /**
     * Return the system's permission sets.
     *
     * @return  Array.
     */
    public function permissionSets()
    {
        return $this->permission_sets;
    }

    /**
     * Add a new permission set to the system.
     *
     * @param   String
     * @param   String
     * @param   Array
     * @return  Void
     */
    public function addPermissionSet($name, $slug, array $permissions = array())
    {
        array_push($this->permission_sets, array('name' => $name, 'slug' => $slug, 'permissions' => $permissions));
    }
}