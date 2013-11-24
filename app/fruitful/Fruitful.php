<?php
/**
 * Fruitful System
 *
 * Base system class that ties everything together. Provides access
 * to the core system libraries required to connect to and interact
 * with the system.
 *
 * @author	Arran Jacques
 */

use Fruitful\Core\UserAuthentication;
use Fruitful\Core\SystemUser;
use Fruitful\Core\SystemPackages;
use Fruitful\Core\SystemMessages;

class Fruitful {

	/**
	 * Instance of the system's user authentication library.
	 *
	 * @var		Fruitful\Core\UserAuthentication
	 */
	protected $auth;

	/**
	 * Instance of the system's packages library.
	 *
	 * @var		Fruitful\Core\SystemPackages
	 */
	public $packages;

	/**
	 * Instance of the system's messages library.
	 *
	 * @var		Fruitful\Core\SystemPackages
	 */
	public $messages;

	/**
	 * System user.
	 *
	 * @var		Fruitful\Core\SystemUser
	 */
	public $user;

	/**
	 * Initialise system.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->auth = new UserAuthentication;
		$this->packages = new SystemPackages;
		$this->messages = new SystemMessages;
		$this->input = \Input::all();

		if (isset($this->input['logout']))
		{
			$this->auth->logout();
		}

		if (\Auth::check())
		{
			$user_details = \Auth::user();
			if ($user_details['active'])
			{
				$this->user = new SystemUser($user_details->toArray());
			}
		}
		else
		{
			$this->user = new SystemUser($this->auth->createGuestUser());
		}
	}
	
	/**
	 * Check if system user is logged in
	 *
	 * @return	Boolean
	 */
	public function isUserLoggedIn()
	{

	}

	/**
	 * Check if system user is logged in and has admin privileges
	 *
	 * @return	Boolean
	 */
	public function isAdminUserLoggedIn()
	{
		if (\Auth::check())
		{
			if ($logged_in_user = \Auth::user())
			{
				if ($this->user->id == $logged_in_user['id'] AND $this->user->hasAccessPrivileges('admin'))
				{
					return true;
				}
			}
		}
		return false;
	}
}