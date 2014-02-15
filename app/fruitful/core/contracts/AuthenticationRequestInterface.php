<?php
namespace Fruitful\Core\Contracts;
/**
 * Authentication Request Interface.
 *
 * Contract for system authentication requests.
 *
 * @author	Arran Jacques
 */

interface AuthenticationRequestInterface
{
	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct();

	/**
	 * Set the user to authenticate.
	 *
	 * @param	String
	 * @param	String
	 * @return	Void
	 */
	public function setUser($email, $password);

	/**
	 * Check if the user details provided are valid values for an
	 * authentication request.
	 *
	 * @return	Boolean
	 */
	public function validates();

	/**
	 * Attempt to authenticate the user with the system and log them in.
	 *
	 * @param	Boolean
	 * @return	Boolean
	 */
	public function attempt($as_admin = false);
}