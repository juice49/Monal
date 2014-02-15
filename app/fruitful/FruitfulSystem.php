<?php
namespace Fruitful;
/**
 * Fruitful System.
 *
 * Base system class that ties everything together.
 *
 * @author	Arran Jacques
 */

class FruitfulSystem
{
	/**
	 * Instance of class implementing DashboardInterface.
	 *
	 * @var		 Fruitful\Core\Contracts\DashboardInterface
	 */
	public $dashboard;

	/**
	 * Instance of class implementing PermissionsInterface.
	 *
	 * @var		 Fruitful\Core\Contracts\PermissionsInterface
	 */
	public $permissions;

	/**
	 * Instance of class implementing MessagesInterface.
	 *
	 * @var		 Fruitful\Core\Contracts\MessagesInterface
	 */
	public $messages;

	/**
	 * System user.
	 *
	 * @var		Fruitful\Core\SystemUser
	 */
	public $user;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->dashboard = \App::make('Fruitful\Core\Contracts\DashboardInterface');
		$this->permissions = \App::make('Fruitful\Core\Contracts\PermissionsInterface');
		$this->messages = \App::make('Fruitful\Core\Contracts\MessagesInterface');
	}
}