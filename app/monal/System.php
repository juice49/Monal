<?php
namespace Monal;
/**
 * System.
 *
 * Base system class that ties everything together.
 *
 * @author	Arran Jacques
 */

class System
{
	/**
	 * Instance of class implementing DashboardInterface.
	 *
	 * @var		 Monal\Core\Contracts\DashboardInterface
	 */
	public $dashboard;

	/**
	 * Instance of class implementing PermissionsInterface.
	 *
	 * @var		 Monal\Core\Contracts\PermissionsInterface
	 */
	public $permissions;

	/**
	 * Instance of class implementing MessagesInterface.
	 *
	 * @var		 Monal\Core\Contracts\MessagesInterface
	 */
	public $messages;

	/**
	 * System user.
	 *
	 * @var		Monal\Core\SystemUser
	 */
	public $user;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->dashboard = \App::make('Monal\Core\Dashboard');
		$this->permissions = \App::make('Monal\Core\Permissions');
		$this->messages = \App::make('Monal\Core\Contracts\MessagesInterface');
	}
}