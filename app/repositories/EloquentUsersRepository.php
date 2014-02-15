<?php 
/**
 * Eloquent Users Repository.
 *
 * @author Arran Jacques
 */

use Fruitful\Repositories\Contracts\UsersRepository;

class EloquentUsersRepository extends \Eloquent implements UsersRepository
{
	/**
	 * The database table used by the repository.
	 *
	 * @var		String
	 */
	 protected $table = 'users';

	/**
	 * Relationships to eager load.
	 *
	 * @var		String
	 */
	 protected $with = array('groupDetails');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var		Array
	 */
	protected $hidden = array('password', 'salt');

	/**
	 * Table relationship.
	 *
	 * @return	Mixed
	 */
	public function groupDetails()
	{
		return $this->belongsTo('EloquentUserGroupsRepository', 'group');
	}

	/**
	 * Retrieve an instance/s from the repository.
	 *
	 * @param	Integer
	 * @return	Illuminate\Support\Collection / MYSQLUsersRepository
	 */
	public function retrieve($key = null)
	{
	}

	/**
	 * Write an instance to the repository.
	 *
	 * @return	MYSQLUsersRepository
	 */
	public function write()
	{
	}
}