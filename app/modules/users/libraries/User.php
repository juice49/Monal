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
	 * Set the user data for the object's instance
	 *
	 * @param	Array
	 * @return	Void
	 */
	public function setUser($data)
	{
		$this->user_data = $data;
	}

	/**
	 * Check user has privileges to access an area of the CMS
	 *
	 * @return Void
	 */
	public function hasAccessPrivileges($area)
	{
		$user_group = \UserGroups_m::find($this->user_data['group']);
		if (isset($user_group) && !empty($user_group))
		{
			if ($user_group->active)
			{
				switch ($area)
				{
					case 'CMS':
						if($user_group->id == 1)
						{
							return true;
						}
				        break;
				}
			}
		}
		return false;
	}
}