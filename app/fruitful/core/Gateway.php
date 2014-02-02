<?php namespace Fruitful\Core;
/**
 * System Gateway.
 *
 * Gateway class for making authentication requests to login to the
 * system.
 *
 * @author	Arran Jacques
 */

use Fruitful\Core\Contracts\GatewayInterface;

class Gateway extends \Fruitful implements GatewayInterface {

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		parent::__construct();
		if ($user_details = $this->auth->currentUser())
		{
			if ($user_details->active)
			{
				$this->setSystemUser($user_details->toArray());
			}
			else
			{
				$this->logoutSystemUser();
			}
		}
		else
		{
			$this->setSystemUser(array('id' => 'guest'));
		}
	}

	/**
	 * Set the system user.
	 *
	 * @param	Array
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
		return $this->auth->login($this->user->email, $password);
	}

	/**
	 * Logout current system user.
	 *
	 * @return	Void
	 */
	public function logoutSystemUser()
	{
		$this->auth->logout();
	}
}