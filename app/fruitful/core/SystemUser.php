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
	 * User's group name.
	 *
	 * @var		String
	 */
	public $group_name;

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
	 * User's active state.
	 *
	 * @var		INT
	 */
	protected $active;

	/**
	 * User's group active state.
	 *
	 * @var		String
	 */
	protected $group_active;

	/**
	 * User group's permissions.
	 *
	 * @var		String
	 */
	protected $permissions;

	/**
	 * Initialise the instance.
	 *
	 * @return	Void
	 */
	public function __construct(array $details)
	{
		$this->id = isset($details['id']) ? $details['id'] : null;
		$this->first_name = isset($details['first_name']) ? $details['first_name'] : null;
		$this->last_name = isset($details['last_name']) ? $details['last_name'] : null;
		$this->username = isset($details['username']) ? $details['username'] : null;
		$this->email = isset($details['email']) ? $details['email'] : null;
		$this->group_id = isset($details['group']) ? $details['group'] : null;
		$this->active = isset($details['active']) ? $details['active'] : null;
		$this->created_at = isset($details['created_at']) ? $details['created_at'] : null;
		$this->updated_at = isset($details['updated_at']) ? $details['updated_at'] : null;

		$user_group = \UserGroups_m::find($this->group_id);
		$this->group_name = isset($user_group['name']) ? $user_group['name'] : null;
		$this->group_active = isset($user_group['active']) ? $user_group['active'] : null;

		$permissions = \UserGroupPermissions_m::findByGroup($this->group_id);
		$this->permissions = ($permissions) ? $permissions : null;
	}

	/**
	 * Is the user a guest.
	 *
	 * @return	Boolean
	 */
	public function isGuest()
	{
		return ($this->id == 'guest') ? true : false;
	}

	/**
	 * Is the user active.
	 *
	 * @return	Boolean
	 */
	public function isUserActive()
	{
		return ($this->active) ? true : false;
	}

	/**
	 * Is the user active.
	 *
	 * @return	Boolean
	 */
	public function isUserGroupActive()
	{
		return ($this->group_active) ? true : false;
	}

	/**
	 * Is the user and user group active.
	 *
	 * @return	Boolean
	 */
	public function isActive()
	{
		return ($this->isUserActive() AND $this->isUserGroupActive()) ? true : false;
	}

	/**
	 * Is the user a global admin.
	 *
	 * @return	Boolean
	 */
	public function isGlobalAdmin()
	{
		return ($this->group_id == 1) ? true : false;
	}

	/**
	 * Is the user an admin.
	 *
	 * @return	Boolean
	 */
	public function isAdmin()
	{
		return ($this->permissions AND $this->permissions->admin) ? true : false;
	}

	/**
	 * Return the user's admin permissions as an array.
	 *
	 * @return	Array
	 */
	public function adminPermissions()
	{
		if ($this->permissions)
		{
			return json_decode($this->permissions->admin_permissions, true);
		}
		return array();
	}

	/**
	 * Check user's admin permissions.
	 *
	 * @return	Boolean
	 */
	public function hasAdminPermissions($hi_level = null, $low_level = null)
	{
		if ($hi_level)
		{
			if ($this->group_id == 1)
			{
				return true;
			}
			if ($this->isAdmin())
			{
				if ($hi_level == 'admin')
				{
					return true;
				}
				$user_permissions = $this->adminPermissions();
				if (!$low_level AND isset($user_permissions[$hi_level]))
				{
					return true;
				}
				else if (isset($user_permissions[$hi_level][$low_level]))
				{
					return true;
				}
			}
		}
		return false;
	}
}