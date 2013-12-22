<?php 
/**
 * User Group Permissions Model
 *
 * Model for the user_group_permissions table.
 *
 * @author Arran Jacques
 */

class UserGroupPermissions_m extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var		String
	 */
	protected $table = 'user_group_permissions';

	/**
	 * Find a permssions set by it's group ID.
	 *
	 * @param	Int
	 * @return	UserGroupPermissions_m / Boolean
	 */
	public static function findByGroup($group_id)
	{
		$user_group_permissions = self::select('*')->where('group', '=', $group_id)->first(); 
		return ($user_group_permissions) ? $user_group_permissions : false;
	}

	/**
	 * Save a new permissions set to the database.
	 *
	 * @return	UserGroupPermissions_m / Boolean
	 */
	public static function createUserGroupPermissions(array $data)
	{
		$user_group_permissions = new self;
		$user_group_permissions->group = isset($data['group']) ? $data['group'] : null;
		$user_group_permissions->admin = isset($data['admin']) ? $data['admin'] : null;
		$user_group_permissions->admin_permissions = isset($data['admin_permissions']) ? $data['admin_permissions'] : null;
		return ($user_group_permissions->save()) ? $user_group_permissions : false;
	}
}