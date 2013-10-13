<?php namespace App\Modules\Users\Contracts;

interface UsersManagerInterface {

	/**
	 * Get all users along with their respective user groups
	 *
	 * @return	array
	 */
	public function getUsers();

	/**
	 * Get all user groups
	 *
	 * @return	array
	 */
	public function getUserGroups();

	/**
	 * Save a new user group
	 *
	 * @param	array
	 * @return	boolean
	 */
	public function saveUserGroup($data);
}