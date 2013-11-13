<?php namespace App\Modules\Users;
/**
 * User Manager
 *
 * Library for preforming out CRUD actions on users and user groups
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
	 * Get all users that belong to a given user group
	 *
	 * @param	Int
	 * @return	Array / Boolean
	 */
	public function getUsersByGroup($group_id)
	{
		$users =  \Users_m::findByGroup($group_id);
		if ($users)
		{
			$users =  $users->toArray();
			$group = $this->getUserGroup($group_id);
			foreach ($users as &$user)
			{
				$user['group'] = $group;
			}
			return $users;
		}
		return false;
	}

	/**
	 * Create a new user
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function createUser($data)
	{
		if (isset($data['email']) && isset($data['password']) && isset($data['user_group']))
		{
			$user = new \Users_m();
			$user->first_name = isset($data['first_name']) ? $data['first_name'] : null;
			$user->last_name = isset($data['last_name']) ? $data['last_name'] :  null;
			$user->username = isset($data['username']) ? $data['username'] : null;
			$user->email = $data['email'];
			$user->password = \Hash::make($data['password']);
			$user->group = $data['user_group'];
			$user->active = isset($data['active']) ? $data['active'] : 0;
			if ($user->save())
			{
				return true;
			}
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
			$user->first_name  = isset($data['first_name']) ? $data['first_name'] : $user->first_name;
			$user->last_name  = isset($data['last_name']) ? $data['last_name'] : $user->last_name;
			$user->username = isset($data['username']) ? $data['username'] : $user->username;
			$user->email = isset($data['email']) ? $data['email'] : $user->email;
			$user->group = isset($data['user_group']) ? $data['user_group'] : $user->group;
			$user->active = isset($data['active']) ? $data['active'] : $user->active;
			$user->password = isset($data['password']) ? \Hash::make($data['password']) : $user->password;
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
			if ($user->save())
			{
				return true;
			}
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
		$group->name  = isset($data['name']) ? $data['name'] : 'unnamed';
		$group->active  = isset($data['active']) ? $data['active'] : 0;
		if ($group->save())
		{
			$this->createUserGroupPrivileges($group->id, $data);
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
			$group->name  = isset($data['name']) ? $data['name'] : $group->name;
			if ($group->id != 1)
			{
				$group->active  = isset($data['active']) ? $data['active'] : $group->active;
				$this->editUserGroupPrivileges($group_id, $data);
			}
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
				if ($group->save())
				{
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Return a group's privilege set
	 *
	 * @param	Int
	 * @return	Array / Boolean
	 */
	public function getGroupPrivileges($group_id)
	{
		$privileges = \UserGroupPrivileges_m::findByGroup($group_id);
		if ($privileges)
		{
			$privileges->modules_backend = json_decode($privileges->modules_backend, true);
			return $privileges->toArray();
		}
		return false;
	}

	/**
	 * Create a new privilege set for a user group
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function createUserGroupPrivileges($group_id, $data)
	{
		$privileges = new \UserGroupPrivileges_m();
		$privileges->group = $group_id;
		$privileges->cms = (isset($data['cms'])) ? $data['cms'] : 0;
		$modules_backend = array();
		foreach ($data as $key => $value)
		{
			if (strpos($key, 'module_') !== false)
			{
				$modules_backend[$value] = true;
			}
		}
		$privileges->modules_backend = json_encode($modules_backend, JSON_FORCE_OBJECT);
		if ($privileges->save())
		{
			return true;
		}
		return false;
	}

	/**
	 * Edit a user group's privilege set
	 *
	 * @param	Int
	 * @param	Array
	 * @return	Boolean
	 */
	public function editUserGroupPrivileges($group_id, $data)
	{
		$privileges = \UserGroupPrivileges_m::findByGroup($group_id);
		if ($privileges)
		{
			$privileges->cms = (isset($data['cms'])) ? $data['cms'] : $privileges->cms;

			$modules_backend = array();
			foreach ($data as $key => $value)
			{
				if (strpos($key, 'module_') !== false)
				{
					$modules_backend[$value] = true;
				}
			}
			$privileges->modules_backend = json_encode($modules_backend, JSON_FORCE_OBJECT);
			if ($privileges->save())
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Counts the number active users with an administrator role
	 *
	 * @return	Int
	 */
	public function countActiveAdministrators()
	{
		$count = 0;
		$users = $this->getUsersByGroup(1);
		if(count($users) <= 1)
		{
			$count = 1;
		}
		else
		{
			foreach ($users as $user)
			{
				if($user['active'])
				{
					$count++;
				}
			}
		}
		return $count;
	}
}