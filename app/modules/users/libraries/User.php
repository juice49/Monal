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
	public $details;

	/**
	 * Initialise user object
	 *
	 * @param	Array		The details of the user to initialise the
	 *						instance with
	 */
	public function __construct($details)
	{
		if (is_array($details))
		{
			$this->details = $details;
		}
		else
		{
			$this->details = array();
		}
	}

	/**
	 * Check user has privileges to access an area of the CMS
	 *
	 * @return	Boolean
	 */
	public function hasAccessPrivileges($area)
	{
		if ($this->details['group'] == 1)
		{
			return true;
		}
		$user_group = \UserGroups_m::find($this->details['group']);
		if (isset($user_group) && !empty($user_group))
		{
			if ($user_group->active)
			{
				$group_privileges = \UserGroupPrivileges_m::findByGroup($user_group->id);
				if ($group_privileges)
				{
					if ($area == 'CMS')
					{
						if($group_privileges->cms == 1)
						{
							return true;
						}
					}
					else
					{
						$module = \Modules_m::findBySlug($area);
						if ($module)
						{
							$group_privileges->modules_backend = json_decode($group_privileges->modules_backend, true);
							if (isset($group_privileges->modules_backend[$module->id]) && $group_privileges->modules_backend[$module->id])
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