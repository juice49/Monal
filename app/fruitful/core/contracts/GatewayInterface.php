<?php
namespace Fruitful\Core\Contracts;
/**
 * Gateway.
 *
 * Class for making authentication requests to the system.
 *
 * @author	Arran Jacques
 */

interface GatewayInterface
{
	/**
	 * Create a new authentication request.
	 *
	 * @param	String
	 * @param	String
	 * @return	Fruitful\Core\AuthenticationRequest
	 */
	public function newAuthRequest($email, $password);

	/**
	 * Check if the current user has already been authenticated.
	 *
	 * @param	Boolean
	 * @return	Boolean
	 */
	public function attemptAuthFromSession($is_admin = false);

	/**
	 * Revoke the current user’s authentication.
	 *
	 * @return	Void
	 */
	public function revokeAuth();
}