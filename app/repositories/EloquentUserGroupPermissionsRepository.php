<?php 
/**
 * Eloquent User Group Permissions Repository.
 *
 * @author Arran Jacques
 */

use Fruitful\Repositories\Contracts\UserGroupPermissionsRepository;

class EloquentUserGroupPermissionsRepository extends \Eloquent implements UserGroupPermissionsRepository
{
	/**
	 * The database table used by the repository.
	 *
	 * @var		String
	 */
	protected $table = 'user_group_permissions';

	/**
	 * Retrieve an instance/s from the repository.
	 *
	 * @param	Integer
	 * @return	Illuminate\Support\Collection / MYSQLUserGroupPermissionsRepository
	 */
	public function retrieve($key = null)
	{
	}

	/**
	 * Write an instance to the repository.
	 *
	 * @return	MYSQLUserGroupPermissionsRepository
	 */
	public function write()
	{
	}
}