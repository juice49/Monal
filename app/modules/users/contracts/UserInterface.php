<?php namespace App\Modules\Users\Contracts;

interface UserInterface {

	/**
	 * Set the user data for the object instance
	 *
	 * @param	array
	 * @return	void
	 */
	public function setUser($data);

	/**
	 * Check user has privileges for the area they are trying to
	 * access
	 *
	 * @return void
	 */	
	public function hasPrivileges();
}