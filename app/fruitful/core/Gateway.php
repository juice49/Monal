<?php
namespace Fruitful\Core;
/**
 * Gateway.
 *
 * Gateway class into the system. Provides methods for user
 * authentication.
 *
 * @author	Arran Jacques
 */

use Fruitful\FruitfulSystem;
use Fruitful\Core\Contracts\GatewayInterface;

class Gateway extends FruitfulSystem implements GatewayInterface
{
	/**
	 * Create a new authentication request.
	 *
	 * @param	String
	 * @param	String
	 * @return	Fruitful\Core\AuthenticationRequest
	 */
	public function newAuthRequest($email, $password)
	{
		$this->revokeAuth();
		$authentication = \App::make('Fruitful\Core\Contracts\AuthenticationRequestInterface');
		$authentication->setUser($email, $password);
		return $authentication;
	}

	/**
	 * Check if the current user has already been authenticated.
	 *
	 * @param	Boolean
	 * @return	Boolean
	 */
	public function attemptAuthFromSession($is_admin = false)
	{
		$user = (\Auth::check()) ? \Auth::user() : false;
		if ($user) {
			if ($user->active) {
				if ($is_admin) {
					if ($user->GroupDetails->id != 1 AND !$user->GroupDetails->groupPermissions->admin) {
						$this->user = new \Fruitful\Core\FruitfulUser();
						return false;
					}
				}
				$this->user = new \Fruitful\Core\FruitfulUser($user->toArray());
				return true;
			}
			$this->revokeAuth();
		}
		$this->user = new \Fruitful\Core\FruitfulUser();
		return false;
	}

	/**
	 * Revoke the current user’s authentication.
	 *
	 * @return	Void
	 */
	public function revokeAuth()
	{
		\Auth::logout();
	}
}