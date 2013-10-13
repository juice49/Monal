<?php 
/**
 *
 */

use Illuminate\Auth\Reminders\RemindableInterface;

class UserGroups_m extends Eloquent {

	/**
	 * The database table used by the model
	 *
	 * @var		string
	 */
	protected $table = 'user_groups';

	/**
	 * Find a user group by its name
	 *
	 * @param	string
	 * @return	mixed
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