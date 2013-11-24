<?php namespace Fruitful\Core;
/**
 * System User
 *
 * Provides access to and functions to interact with a system user.
 *
 * @author	Arran Jacques
 */

class SystemUser {

	/**
	 * User's ID.
	 *
	 * @var		Int
	 */
	public $id;

	/**
	 * User's first name.
	 *
	 * @var		String
	 */
	public $first_name;

	/**
	 * User's last name.
	 *
	 * @var		String
	 */
	public $last_name;

	/**
	 * User's username.
	 *
	 * @var		String
	 */
	public $username;

	/**
	 * User's email address.
	 *
	 * @var		String
	 */
	public $email;

	/**
	 * The ID of the user group that the user belongs to.
	 *
	 * @var		Int
	 */
	public $group_id;

	/**
	 * User's active state.
	 *
	 * @var		INT
	 */
	public $active;

	/**
	 * Unix timestamp of users last successful login.
	 *
	 * @var		Int
	 */
	public $last_logged_in;

	/**
	 * Timestamp of when user was first created and saved in the system's
	 * database.
	 *
	 * @var		String
	 */
	public $created_at;

	/**
	 * Timestamp of when user was lasted updated and saved in the system's
	 * database.
	 *
	 * @var		String
	 */
	public $updated_at;

	/**
	 * Initialise the instance.
	 *
	 * @return	Void
	 */
	public function __construct(array $details)
	{
		if (is_array($details) AND !empty($details))
		{
			$this->id = isset($details['id']) ? $details['id'] : null;
			$this->first_name = isset($details['first_name']) ? $details['first_name'] : null;
			$this->last_name = isset($details['last_name']) ? $details['last_name'] : null;
			$this->username = isset($details['username']) ? $details['username'] : null;
			$this->email = isset($details['email']) ? $details['email'] : null;
			$this->group_id = isset($details['group']) ? $details['group'] : null;
			$this->active = isset($details['active']) ? $details['active'] : null;
			$this->last_logged_in = isset($details['last_logged_in']) ? $details['last_logged_in'] : null;
			$this->created_at = isset($details['created_at']) ? $details['created_at'] : null;
			$this->updated_at = isset($details['updated_at']) ? $details['updated_at'] : null;
		}
	}

	/**
	 * Check user has privileges to access an area of the system.
	 *
	 * @return	Boolean
	 */
	public function hasAccessPrivileges($area = null)
	{
		if ($this->group_id == 1)
		{
			return true;
		}
		$user_group = \UserGroups_m::find($this->group_id);
		if (isset($user_group) && !empty($user_group))
		{
			if ($user_group->active)
			{
				$group_privileges = \UserGroupPrivileges_m::findByGroup($user_group->id);
				if ($group_privileges)
				{
					if ($area == 'admin' AND $group_privileges->admin == 1)
					{
						return true;
					}
					else
					{
						$package = \Packages_m::findBySlug($area);
						if ($package)
						{
							$group_privileges->package_admin_access = json_decode($group_privileges->package_admin_access, true);
							if (isset($group_privileges->package_admin_access[$package->id]) && $group_privileges->package_admin_access[$package->id])
							{
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}
}