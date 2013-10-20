<?php 
/**
 *
 */

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Users_m extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model
	 *
	 * @var		string
	 */
	 protected $table = 'users';

	 /**
	 * The attributes excluded from the model's JSON form
	 *
	 * @var		array
	 */
	protected $hidden = array('password', 'salt');

	/**
	 * Get the unique identifier for the user
	 *
	 * @return	mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return	string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return	string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Find a user by their email address
	 *
	 * @param	string
	 * @return	mixed
	 */
	public static function findByEmail($email)
	{
		$user = self::select('*')->where('users.email', '=', $email)->first();
		if (!$user)
		{
			return false;
		}
		return $user->toArray();
	}

	/**
	 * Find all users that belong to a given group
	 *
	 * @param	Int
	 * @return	Users_m / Boolean
	 */
	public static function findByGroup($group_id)
	{
		$users = self::select('*')->where('users.group', '=', $group_id)->get();
		if ($users && count($users) > 0)
		{
			return $users;
		}
		return false;
	}

	public static function setUsersStatusByGroup($group_id, $status)
	{
		self::where('group', '=', $group_id)->update(array('active' => $status));
		return true;
	}
}