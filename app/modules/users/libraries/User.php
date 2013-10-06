<?php namespace App\Modules\Users;
/**
 * User
 *
 * Library for managing a site user 
 *
 * @author Arran Jacques
 */

class User implements Contracts\UserInterface {

	public function __construct(\App\Modules\Users\Contracts\UserModelInterface $model)
	{
		$this->model = $model;
	}

	/**
	 * Save user data to object
	 *
	 * @return	void
	 */
	public function setUser(array $user)
	{
		$this->data = $user;
	}

	/**
	 * Check user has privileges for the area they are trying to
	 * access
	 *
	 * @return void
	 */
	public function hasPrivileges()
	{
		if ($this->data['active'] == 1 and $this->data['role'] == 1)
		{
			return true;
		}
		return false;
	}
}