<?php namespace App\Modules\Users;
/**
 * User
 *
 * Library for managing a site user 
 *
 * @author Arran Jacques
 */

use App\Modules\Users\Contracts\UserInterface;

class User implements UserInterface {

	/**
	 * User's data
	 *
	 * @var		array
	 */
	public $user_data;

	/**
	 * Set the user data for the object instance
	 *
	 * @param	array
	 * @return	void
	 */
	public function setUser($data)
	{
		$this->user_data = $data;
	}

	/**
	 * Check user has privileges for the area they are trying to
	 * access
	 *
	 * @return void
	 */
	public function hasPrivileges()
	{
		if ($this->user_data['active'] == 1 and $this->user_data['group'] == 1)
		{
			return true;
		}
		return false;
	}
}