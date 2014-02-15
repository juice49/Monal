<?php
namespace Fruitful\Core\Contracts;
/**
 * Permissions Interaface.
 *
 * Contract for system permissions class.
 *
 * @author	Arran Jacques
 */

interface PermissionsInterface
{
	/**
	 * Return the system's permission sets.
	 *
	 * @return	Array.
	 */
	public function permissionSets();

	/**
	 * Add a new permission set to the system.
	 *
	 * @param	String
	 * @param	String
	 * @param	Array
	 * @return	Void
	 */
	public function addPermissionSet($name, $slug, array $permissions = array());
}