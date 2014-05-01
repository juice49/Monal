<?php
namespace Fruitful;
/**
 * Gateway.
 *
 * Gateway class into the system. Provides methods for user
 * authentication.
 *
 * @author	Arran Jacques
 */

class Gateway extends System implements GatewayInterface
{
	/**
	 * Create a new authentication request.
	 *
	 * @return	Fruitful\Core\AuthenticationRequest
	 */
	public function newAuthRequest()
	{
		$this->revokeAuth();
		return \App::make('Fruitful\Models\AuthenticationRequest');
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
						$this->user = new \Fruitful\Models\SystemUser();
						return false;
					}
				}
				$this->user = new \Fruitful\Models\SystemUser($user->toArray());
				return true;
			}
			$this->revokeAuth();
		}
		$this->user = new \Fruitful\Models\SystemUser();
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