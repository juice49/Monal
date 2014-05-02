<?php
/**
 * Installation Controller.
 *
 * @author	Arran Jacques
 */

use Monal\GatewayInterface;

class InstallationController extends BaseController
{
	/**
	 * Installer Library.
	 *
	 * @var		Installer
	 */
	protected $installer;

	/**
	 * Constructor.
	 *
	 * @param	Monal\GatewayInterface
	 * @param	Installer
	 * @return	Void
	 */
	public function __construct(GatewayInterface $system_gateway, Installer $installer)
	{
		parent::__construct($system_gateway);
		$this->installer = $installer;
	}

	/**
	 * Control and display install database page.
	 *
	 * @return	Illuminate\View\View
	 */
	public function database()
	{
		if ($this->input) {
			if (Session::token() != $this->input['_token']) {
				throw new Illuminate\Session\TokenMismatchException;
			}
			if ($this->installer->installDatabase($this->input, isset($this->input['create']))) {
				return Redirect::route('installation.user');
			}
			$this->system->messages->add($this->installer->messages()->toArray());
		}
		$database_management_systems = array(
			'mysql' => 'MySQL',
			);
		$messages = $this->system->messages->get();
		return View::make('installation.database', compact('messages', 'database_management_systems'));
	}

	/**
	 * Control and display create user page.
	 *
	 * @return	Illuminate\View\View
	 */
	public function user()
	{
		if ($this->input)
		{
			if (Session::token() != $this->input['_token']) {
				throw new Illuminate\Session\TokenMismatchException;
			}
			if ($this->installer->createUser($this->input)) {
				return Redirect::route('installation.remove');
			}
			$this->system->messages->add($this->installer->messages()->toArray());
		}
		$messages = $this->system->messages->get();
		return View::make('installation.user', compact('messages'));
	}

	/**
	 * Control and display remove installation files page.
	 *
	 * @return	Illuminate\View\View
	 */
	public function remove()
	{
		if (isset($this->input['remove']))
		{
			if (Session::token() != $this->input['_token']) {
				throw new Illuminate\Session\TokenMismatchException;
			}
			if ($this->installer->deleteInstallationFiles()) {
				return Redirect::route('admin.login');
			}
			$this->system->messages->add($this->installer->messages()->toArray());
		}
		$messages = $this->system->messages->get();
		return View::make('installation.remove', compact('messages'));
	}
}