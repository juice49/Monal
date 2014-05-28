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
	 * The system's messages.
	 *
	 * @var		Monal\Core\Contracts\MessagesInterface
	 */
	public $messages;

	/**
	 * The system's dashboard class.
	 *
	 * @var		Monal\Core\Dashboard
	 */
	public $dashboard;

	/**
	 * The system's permissions class.
	 *
	 * @var		Monal\Core\Permissions
	 */
	public $permissions;

	/**
	 * The system's current user.
	 *
	 * @var		Monal\Models\SystemUser
	 */
	public $user;

	/**
	 * An array of closures to attempt upon each request to the system.
	 *
	 * @var		Array
	 */
	public $route_logic = array();

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