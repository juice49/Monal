<?php 
/**
 * Eloquent Authentication Repository.
 *
 * @author	Arran Jacques
 */

use Fruitful\Repositories\Contracts\AuthenticationRepository;
use Illuminate\Auth\UserInterface;

class EloquentAuthenticationRepository extends \Eloquent implements AuthenticationRepository, UserInterface
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
	 * Return the unique identifier for the user.
	 *
	 * @return	Mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return the password for the user.
	 *
	 * @return	String
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Return the e-mail address where password reminders are sent.
	 *
	 * @return	String
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Retrieve a user from the repository by their email address.
	 *
	 * @param	String
	 * @return	MYSQLAuthenticationRepository
	 */
	public function retrieve($email)
	{
		$user = self::where('email',  '=', $email)->first();
		$user->group_details->group_permissions->admin_permissions = json_decode($user->group_details->group_permissions->admin_permissions, true);
		return $user;
	}
}