<?php namespace Fruitful\Core;
/**
 * User Authentication
 *
 * Authenticate user details and log them into and out of the system.
 *
 * @author	Arran Jacques
 */

use App\Fruitful\Core\User;

class UserAuthentication {

	public $user;

	/**
	 * Check a user exists.
	 *
	 * @param	Mixed
	 * @return	Array / Boolean
	 */
	public function userExists($identifier = null)
	{
		if ($identifier AND $user = \Users_m::findByEmail($identifier))
		{
			$this->user = $user;
			return $this->user->toArray();
		}
		return false;
	}

	/**
	 * Log user in.
	 *
	 * @param	String
	 * @param	String
	 * @return	Boolean
	 */
	public function login($email = null, $password = null)
	{
		if ($this->user->active)
		{
			if (\Auth::attempt(array('email' => $email, 'password' => $password), false))
			{
				$this->user->updateUsersLoginTime();
				return true;
			}
		}
		return false;
	}

	/**
	 * Log user out.
	 *
	 * @return	Void
	 */
	public function logout()
	{
		\Auth::logout();
	}

	/**
	 * Return an array of default user details to be used as a guest user.
	 *
	 * @return	Array
	 */
	public function createGuestUser()
	{
		$guest = array(
			'id' => null,
			'first_name' => 'Guest',
			'last_name' => 'User',
			'username' => null,
			'email' => null,
			'group_id' => null,
			'active' => null,
			'last_logged_in' => null,
			'created_at' => null,
			'updated_at' => null,
			);
		return $guest;
	}
}