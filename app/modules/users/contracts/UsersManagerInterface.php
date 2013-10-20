<?php namespace App\Modules\Users\Contracts;

interface UsersManagerInterface {

	/**
	 * Get a user by their ID along with their respective user group
	 *
	 * @param	Int
	 * @return	Array / Boolean
	 */
	public function getUser($user_id);

	/**
	 * Get all users along with their respective user groups
	 *
	 * @return	Array
	 */
	public function getUsers();

	/**
	 * Get all users that belong to a given user group
	 *
	 * @param	Int
	 * @return	Array / Boolean
	 */
	public function getUsersByGroup($group_id);

	/**
	 * Create a new user
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function createUser($data);

	/**
	 * Edit an existing user
	 *
	 * @param	Int
	 * @param	Array
	 * @return	Boolean
	 */
	public function editUser($user_id, $data);

	/**
	 * Switches a user's active status around
	 *
	 * @param	Int
	 * @return	Boolean
	 */
	public function switchUsersStatus($user_id);

	/**
	 * Get a user group by its ID
	 *
	 * @param	Int
	 * @return	Array / Boolean
	 */
	public function getUserGroup($group_id);

	/**
	 * Get all user groups
	 *
	 * @return	Array
	 */
	public function getUserGroups();

	/**
	 * Create a new user group
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function createUserGroup($data);

	/**
	 * Edit an existing user group
	 *
	 * @param	Int
	 * @param	Array
	 * @return	Boolean
	 */
	public function editUserGroup($group_id, $data);

	/**
	 * Switches a groups active status around
	 *
	 * @param	Int
	 * @return	Boolean
	 */
	public function switchUserGroupsStatus($group_id);

	/**
	 * Counts the number active users with an administrator role
	 *
	 * @return	Int
	 */
	public function countActiveAdministrators();
}