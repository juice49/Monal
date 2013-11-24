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
	 * Set the system user.
	 *
	 * @param	Mixed			The unique identifier to be used to
	 *							retrieve the user from the system's
	 *							database
	 * @return	Boolean
	 */
	public function setSystemUser($identifier);

	/**
	 * Attempt to authenticate and login the system user.
	 *
	 * @return	Boolean
	 */
	public function loginSystemUser($password);
}