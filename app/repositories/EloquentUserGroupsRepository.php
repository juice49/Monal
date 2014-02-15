<?php 
/**
 * Eloquent User Groups Repository.
 *
 * @author Arran Jacques
 */

use Fruitful\Repositories\Contracts\UserGroupsRepository;

class EloquentUserGroupsRepository extends \Eloquent implements UserGroupsRepository
{
	/**
	 * The database table used by the repository.
	 *
	 * @var		String
	 */
	protected $table = 'user_groups';

	/**
	 * Relationships to eager load.
	 *
	 * @var		String
	 */
	protected $with = array('groupPermissions');

	/**
	 * Table relationship.
	 *
	 * @return	Mixed
	 */
	public function groupPermissions()
	{
		return $this->hasOne('EloquentUserGroupPermissionsRepository', 'group');
	}

	/**
	 * Retrieve an instance/s from the repository.
	 *
	 * @param	Integer
	 * @return	Illuminate\Support\Collection / MYSQLUserGroupsRepository
	 */
	public function retrieve($key = null)
	{
	}

	/**
	 * Write an instance to the repository.
	 *
	 * @return	MYSQLUserGroupsRepository
	 */
	public function write()
	{
	}
}