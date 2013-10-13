<?php namespace App\Modules\Users;
/**
 * User Auth
 *
 * Library for managing user authentication across the app
 *
 * @author Arran Jacques
 */

use Illuminate\Auth;
use App\Modules\Users\Contracts\UserAuthInterface;
use App\Modules\Users\Contracts\UserInterface;

class UserAuth implements UserAuthInterface {

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	/**
	 * Check user's credentials and log them in if they pass
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function adminLogin($email = null, $password = null)
	{
		if (!$email or !$password)
		{
			return false;
		}
		if ($user = \Users_m::findByEmail($email))
		{
			$this->user->setUser($user);
			if ($this->user->hasPrivileges())
			{
				if (\Auth::attempt(array('email' => $email, 'password' => $password), false))
				{
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Log user out
	 *
	 * @return	void
	 */
	public function logout()
	{
		\Auth::logout();
	}

	/**
	 * Check if user with admin privileges is logged in
	 *
	 * @return	mixed
	 */
	public function adminLoggedIn()
	{
		if (\Auth::check())
		{
			$this->user->user_data = \Auth::user()->toArray();
			return $this->user;
		}
		return false;
	}
}