<?php 
/**
 * Users Model.
 *
 * Model for the users table.
 *
 * @author Arran Jacques
 */

use Illuminate\Auth\UserInterface;

class Users_m extends Eloquent implements UserInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var		String
	 */
	 protected $table = 'users';

	 /**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var		Array
	 */
	protected $hidden = array('password', 'salt');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return	Mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return	String
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return	String
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Save a user's login time.
	 *
	 * @return	Void
	 */
	public function updateUsersLoginTime()
	{
		$this->last_logged_in = time();
		$this->save();
	}

	/**
	 * Find a user by their email address.
	 *
	 * @param	String
	 * @return	Mixed
	 */
	public static function findByEmail($email)
	{
		$user = self::select('*')->where('users.email', '=', $email)->first();
		if (!$user)
		{
			return false;
		}
		return $user;
	}

	/**
	 * Find all users that belong to a given group.
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

	/**
	 * Update the status of all users within a given user group.
	 *
	 * @param	Int
	 * @param	Int
	 * @return	Boolean
	 */
	public static function updateUsersStatusByGroup($group_id, $status)
	{
		self::where('group', '=', $group_id)->update(array('active' => $status));
		return true;
	}
}