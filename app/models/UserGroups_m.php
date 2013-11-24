<?php 
/**
 * User Group Model
 *
 * Model for the user_groups table.
 *
 * @author Arran Jacques
 */

class UserGroups_m extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var		String
	 */
	protected $table = 'user_groups';

	/**
	 * Find a user group by its name.
	 *
	 * @param	String
	 * @return	Mixed
	 */
	public static function findByName($name)
	{
		$group = self::select('*')->where('name', '=', $name)->first();
		if ($group)
		{
			return $group->toArray();
		}
		return false;
	}
}