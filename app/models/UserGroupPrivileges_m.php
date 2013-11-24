<?php 
/**
 * User Group Privileges Model
 *
 * Model for the user_group_privileges table.
 *
 * @author Arran Jacques
 */

class UserGroupPrivileges_m extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var		String
	 */
	protected $table = 'user_group_privileges';

	/**
	 * Find a privilege set by it's group ID.
	 *
	 * @param	Int
	 * @return	UserGroupPrivileges_m / Boolean
	 */
	public static function findByGroup($group_id)
	{
		$privileges = self::select('*')->where('group', '=', $group_id)->first(); 
		if (isset($privileges) && !empty($privileges))
		{
			return $privileges;
		}
		return false;
	}
}