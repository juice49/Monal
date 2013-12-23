<?php namespace Fruitful\Core;
/**
 * System Gateway
 *
 * Acts as a gateway into the system for making authentication
 * requests.
 *
 * @author	Arran Jacques
 */

use Fruitful\Core\Contracts\GatewayInterface;

class Gateway extends \Fruitful implements GatewayInterface {

	/**
	 * Set the system user.
	 *
	 * @return	Void
	 */
	public function setSystemUser(array $user_details)
	{
		$this->user = new SystemUser($user_details);
	}

	/**
	 * Set the system user by their email address.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function setSystemUserByEmail($email)
	{
		if ($user_details = $this->auth->userExistsByEmail($email))
		{
			$this->setSystemUser($user_details->toArray());
			return true;
		}
		return false;
	}

	/**
	 * Attempt to authenticate and login the system user.
	 *
	 * @return	Boolean
	 */
	public function loginSystemUser($password)
	{
		return ($this->auth->login($this->user->email, $password)) ? true : false;
	}

	/**
	 * Check if system user is logged in and has admin privileges
	 *
	 * @return	Boolean
	 */
	public function isAdminUserLoggedIn()
	{
		if ($user_details = $this->auth->currentUser())
		{
			$this->setSystemUser($user_details->toArray());
			if ($this->user->isAdmin())
			{
				return true;
			}
		}
		return false;
	}
}