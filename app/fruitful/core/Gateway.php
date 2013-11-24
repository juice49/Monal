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
	 * @param	Mixed			The unique identifier to be used to
	 *							retrieve the user from the system's
	 *							database
	 * @return	Boolean
	 */
	public function setSystemUser($identifier)
	{
		if ($user_details = $this->auth->userExists($identifier))
		{
			$this->user = new SystemUser($user_details);
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
		if ($this->auth->login($this->user->email, $password))
		{
			return true;
		}
		return false;
	}
}