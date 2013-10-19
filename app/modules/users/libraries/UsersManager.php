<?php namespace App\Modules\Users;
/**
 * User Manager
 *
 * Library for managing users and user groups
 *
 * @author Arran Jacques
 */

use App\Modules\Users\Contracts\UsersManagerInterface;

class UsersManager implements UsersManagerInterface {

	/**
	 * Get a user by their ID along with their respective user group
	 *
	 * @param	Int
	 * @return	Array / Boolean
	 */
	public function getUser($user_id)
	{
		$user = \Users_m::find($user_id);
		if ($user)
		{
			$user['group'] = $this->getUserGroup($user['group']);
			return $user->toArray();
		}
		return false;
	}

	/**
	 * Get all users along with their respective user groups
	 *
	 * @return	Array
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
	 * Create a new user
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function createUser($data)
	{
		$user = new \Users_m();
		$user->first_name = $data['first_name'];
		$user->last_name = $data['last_name'];
		$user->username = $data['username'];
		$user->email = $data['email'];
		$user->password = \Hash::make($data['password']);
		$user->group = $data['user_group'];
		$user->active = $data['active'];
		if ($user->save())
		{
			return true;
		}
		return false;
	}

	/**
	 * Edit an existing user
	 *
	 * @param	Int
	 * @param	Array
	 * @return	Boolean
	 */
	public function editUser($user_id, $data)
	{
		$user = \Users_m::find($user_id);
		if ($user)
		{
			$user->first_name  = $data['first_name'];
			$user->last_name  = $data['last_name'];
			$user->username = $data['username'];
			$user->email = $data['email'];
			$user->group = $data['user_group'];
			$user->active = $data['active'];
			if (isset($data['password']) && !empty($data['password']))
			{
				$user->password = \Hash::make($data['password']);
			}
			if ($user->save())
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Get a user group by its ID
	 *
	 * @param	Int
	 * @return	Array / Boolean
	 */
	public function getUserGroup($group_id)
	{
		$group = \UserGroups_m::find($group_id);
		if ($group)
		{
			return $group->toArray();
		}
		return false;
	}

	/**
	 * Get all user groups
	 *
	 * @return	Array
	 */
	public function getUserGroups()
	{
		return \UserGroups_m::all()->toArray();
	}

	/**
	 * Switches a user's active status around
	 *
	 * @param	Int
	 * @return	Boolean
	 */
	public function switchUsersStatus($user_id)
	{
		$user = \Users_m::find($user_id);
		if ($user)
		{
			$user->active = ($user->active == 1) ? 0 : 1;
			$user->save();
			return true;
		}
		return false;
	}

	/**
	 * Create a new user group
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function createUserGroup($data)
	{
		$group = new \UserGroups_m();
		$group->name  = $data['name'];
		$group->active  = $data['active'];
		if ($group->save())
		{
			return true;
		}
		return false;
	}

	/**
	 * Edit an existing user group
	 *
	 * @param	Int
	 * @param	Array
	 * @return	Boolean
	 */
	public function editUserGroup($group_id, $data)
	{
		$group = \UserGroups_m::find($group_id);
		if ($group)
		{
			$group->name  = $data['name'];
			$group->active  = $data['active'];
			if ($group->save())
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Switches a group's active status around
	 *
	 * @param	Int
	 * @return	Boolean
	 */
	public function switchUserGroupsStatus($group_id)
	{
		if ($group_id != 1)
		{
			$group = \UserGroups_m::find($group_id);
			if ($group)
			{
				$group->active = ($group->active == 1) ? 0 : 1;
				\Users_m::setUsersStatusByGroup($group_id, $group->active);
				$group->save();
				return true;
			}
		}
		return false;
	}
}