<?php namespace App\Modules\Users;
/**
 * User Manager
 *
 * Library for managing users, user groups and user privileges
 *
 * @author Arran Jacques
 */

use App\Modules\Users\Contracts\UsersManagerInterface;

class UsersManager implements UsersManagerInterface {

	/**
	 * Get all users along with their respective user groups
	 *
	 * @return	array
	 */
	public function getUsers()
	{
		$users =  \Users_m::all()->toArray();
		$groups = $this->getUserGroups();
		$groups_formated = array();
		foreach ($groups as $group)
		{
			$id = $group['id'];
			unset($group['id']);
			$groups_formated[$id] = $group;
		}
		foreach ($users as &$user)
		{
			$user['group'] = $groups_formated[$user['group']];
		}
		return $users;
	}

	/**
	 * Get all user groups
	 *
	 * @return	array
	 */
	public function getUserGroups()
	{
		return \UserGroups_m::all()->toArray();
	}

	/**
	 * Save a new user group
	 *
	 * @param	array
	 * @return	boolean
	 */
	public function saveUserGroup($data)
	{
		$exists = \UserGroups_m::findByName($data['name']);
		if (!$exists)
		{
			$group = new \UserGroups_m();
			$group->name  = $data['name'];
			$group->active  = $data['active'];
			$group->save();
			return true;
		}
		return false;
	}
}