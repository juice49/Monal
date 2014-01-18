<?php
/**
 * Fruitful System.
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
	 * Initialise class.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->auth = new UserAuthentication;
		$this->packages = new SystemPackages;
		$this->messages = new SystemMessages;
	}
}