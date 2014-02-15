<?php
namespace Fruitful\Core;
/**
 * Fruitful User.
 *
 * User class for the current system user. Provides methods for
 * working with the current system user.
 *
 * @author	Arran Jacques
 */

class FruitfulUser
{
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
	 * User's status.
	 *
	 * @var		Integer
	 */
	public $active;

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
	 * User's group details.
	 *
	 * @var		String
	 */
	public $group_details;

	/**
	 * Constructor.
	 *
	 * @param	Array
	 * @return	Void
	 */
	public function __construct(array $details = array())
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
		if (isset($details['group_details'])) {
			$this->group_details = $details['group_details'];
			$this->group_details['group_permissions']['admin_permissions'] = json_decode($this->group_details['group_permissions']['admin_permissions'], true);
		} else {
			$this->group_details = array('group_permissions' => array('admin_permissions' => array()));
		}
	}

	/**
	 * Is the user a guest.
	 *
	 * @return	Boolean
	 */
	public function isGuest()
	{
		return ($this->id === null) ? true : false;
	}

	/**
	 * Is the user logged in.
	 *
	 * @return	Boolean
	 */
	public function isLoggedIn()
	{
		return $this->isGuest() ? false : true;
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
		return ($this->group_details['group_permissions']['admin']) ? true : false;
	}

	/**
	 * Check if the user has an admin permission.
	 *
	 * @param	String
	 * @param	String
	 * @return	Boolean
	 */
	public function hasAdminPermissions($hi_level = null, $low_level = null)
	{
		if ($this->isGlobalAdmin()) {
			return true;
		}
		if ($hi_level) {
			$user_permissions = $this->group_details['group_permissions']['admin_permissions'];
			if (!$low_level AND isset($user_permissions[$hi_level])) {
					return true;
			} elseif (isset($user_permissions[$hi_level][$low_level])){
				return true;
			}
			return false;			
		}
		return $this->isAdmin();
	}
}