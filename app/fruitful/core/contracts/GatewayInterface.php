<?php namespace Fruitful\Core\Contracts;
/**
 * System Gateway Interface
 *
 * Contract for all system gateway classes to abide to.
 *
 * @author	Arran Jacques
 */

interface GatewayInterface {

	/**
	 * Set the system user by their email address.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function setSystemUserByEmail($email);

	/**
	 * Attempt to authenticate and login the system user.
	 *
	 * @return	Boolean
	 */
	public function loginSystemUser($password);
}