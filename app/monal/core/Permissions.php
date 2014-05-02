<?php
namespace Monal\Core;
/**
 * Permissions.
 *
 * Set and read system permission and permission sets. Permission
 * can be granted to objects allowing them to interact with parts of
 * the system, or to carry out specific functions.
 *
 * @author	Arran Jacques
 */

class Permissions
{
	/**
	 * System permssion sets.
	 *
	 * @var		Array
	 */
	protected $permission_sets = array();

	/**
	 * Return the system's permission sets.
	 *
	 * @return	Array.
	 */
	public function permissionSets()
	{
		return $this->permission_sets;
	}

	/**
	 * Add a new permission set to the system.
	 *
	 * @param	String
	 * @param	String
	 * @param	Array
	 * @return	Void
	 */
	public function addPermissionSet($name, $slug, array $permissions = array())
	{
		array_push($this->permission_sets, array('name' => $name, 'slug' => $slug, 'permissions' => $permissions));
	}
}