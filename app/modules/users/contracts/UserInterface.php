<?php namespace App\Modules\Users\Contracts;

interface UserInterface {

	/**
	 * Set the user data for the object's instance
	 *
	 * @param	Array
	 * @return	Void
	 */
	public function setUser($data);

	/**
	 * Check user has privileges to access an area of the CMS
	 *
	 * @return Boolean
	 */
	public function hasAccessPrivileges($area);
}