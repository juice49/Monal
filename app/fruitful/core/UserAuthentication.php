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
	 * Check a user exists by their email address.
	 *
	 * @param	String
	 * @return	Users_m / Boolean
	 */
	public function userExistsByEmail($email = null)
	{
		if ($email AND $user = \Users_m::findByEmail($email))
		{
			$this->user = $user;
			return $this->user;
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
		return array(
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
	}

	/**
	 * Check if a user is logged in.
	 *
	 * @return Users_m / Boolean
	 */
	public function currentUser()
	{
		return (\Auth::check()) ? \Auth::user() : false;
	}
}