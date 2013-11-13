<?php namespace App\Modules\Users\Contracts;

interface UserInterface {

	/**
	 * Initialise user object
	 *
	 * @param	Array		The details of the user to initialise the
	 *						instance with
	 */
	public function __construct($details);
	
	/**
	 * Check user has privileges to access an area of the CMS
	 *
	 * @return Boolean
	 */
	public function hasAccessPrivileges($area);
}