<?php namespace App\Modules\Users\Contracts;

use App\Modules\Users\Contracts\UserInterface;

interface UserAuthInterface {
	
	/**
	 * Check user's credentials and log them in as an admin if they pass
	 *
	 * @param	String
	 * @param	String
	 * @return	Void
	 */
	public function adminLogin($email = null, $password = null);

	/**
	 * Log user out
	 *
	 * @return	Void
	 */
	public function logout();

	/**
	 * Check if user with admin privileges is logged in
	 *
	 * @return	App\Modules\Users\User / Boolean
	 */
	public function adminLoggedIn();
}