<?php
namespace Fruitful\Repositories\Contracts;
/**
 * Repository.
 *
 * @author	Arran Jacques
 */

interface Repository
{
	/**
	 * Retrieve an instance/s from the repository.
	 *
	 * @param	Integer
	 * @return	Mixed
	 */
	public function retrieve($key = null);

	/**
	 * Write an instance to the repository.
	 *
	 * @return	Mixed
	 */
	public function write();
}