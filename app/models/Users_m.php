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
		return ($users) ? $users : false;
	}

	/**
	 * Find all active users.
	 *
	 * @return	Users_m / Boolean
	 */
	public static function findAllActive()
	{
		$users = self::select('*')->where('users.active', '=', 1)->get();
		return ($users) ? $users : false;
	}

	/**
	 * Save a new user to the database.
	 *
	 * @return	Users_m / Boolean
	 */
	public static function createUser(array $data)
	{
		$user = new self;
		$user->first_name = isset($data['first_name']) ? $data['first_name'] : null;
		$user->last_name = isset($data['last_name']) ? $data['last_name'] :  null;
		$user->username = isset($data['username']) ? $data['username'] : null;
		$user->email = isset($data['email']) ? $data['email'] : null;
		$user->password = isset($data['password']) ? \Hash::make($data['password']) : null;
		$user->group = isset($data['group']) ? $data['group'] : null;
		$user->active = isset($data['active']) ? $data['active'] : 0;
		return ($user->save()) ? $user : false;
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