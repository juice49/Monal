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

	protected $users;

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	/**
	 * Check user's credentials and log them in as an admin if they pass
	 *
	 * @param	String
	 * @param	String
	 * @return	Void
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
			if ($this->user->user_data['active'] && $this->user->hasAccessPrivileges('CMS'))
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
	 * @return	Void
	 */
	public function logout()
	{
		\Auth::logout();
	}

	/**
	 * Check if user with admin privileges is logged in
	 *
	 * @return	App\Modules\Users\User / Boolean
	 */
	public function adminLoggedIn()
	{
		if (\Auth::check())
		{
			$this->user->user_data = \Auth::user()->toArray();
			if ($this->user->user_data['active'] && $this->user->hasAccessPrivileges('CMS'))
			{
				return $this->user;
			}
			else
			{
				$this->logout();
			}
		}
		return false;
	}
}