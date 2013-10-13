<?php namespace App\Modules\Users\Contracts;

interface UserAuthInterface {

	public function __construct(\App\Modules\Users\Contracts\UserInterface $user);
	
	/**
	 * Check user's credentials and log them in if they pass
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function adminLogin($email = null, $password = null);

	/**
	 * Log user out
	 *
	 * @return	void
	 */
	public function logout();

	/**
	 * Check if user with admin privileges is logged in
	 *
	 * @return	mixed
	 */
	public function adminLoggedIn();
}