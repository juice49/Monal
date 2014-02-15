<?php
namespace Fruitful\Repositories\Contracts;
/**
 * Authentication Repository.
 *
 * Contract for a repository that stores Users. More specifically for
 * reading users form the repository for authentication requests. 
 *
 * @author	Arran Jacques
 */

interface AuthenticationRepository
{
	/**
	 * Retrieve a user from the repository by their email address.
	 *
	 * @param	String
	 * @return	Mixed
	 */
	public function retrieve($email);
}