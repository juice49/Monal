<?php
/**
 * Admin Controller
 *
 * Base controller for system admin pages,
 *
 * @author	Arran Jacques
 */

use Fruitful\Core\Contracts\GatewayInterface;

class AdminController extends BaseController {

	/**
	 * Instance of the gateway class into the Fruitful system.
	 *
	 * @var		Fruitful\Core\GatewayInterface
	 */
	protected $system;

	/**
	 * Input data
	 *
	 * @var		Array
	 */
	public $input;

	/**
	 * Initialise controller.
	 *
	 * @return	Void
	 */
	public function __construct(GatewayInterface $system_gateway)
	{
		$this->system = $system_gateway;
		$this->input = Input::all();

		View::share('system_user', $this->system->user);

		if ($this->system->isAdminUserLoggedIn())
		{
			$this->control_panel_navigation = $this->buildControlPanelNavigation($this->system->packages->getAllPackageDetails());
			View::share('control_panel', $this->control_panel_navigation);
		}
	}

	/**
	 * Controls and displays admin login page.
	 *
	 * @return	Illuminate\View\View
	 */
	public function login()
	{
		if ($this->system->isAdminUserLoggedIn())
		{
			return Redirect::to('admin');
		}
		if ($this->input)
		{
			$validation = Validator::make($this->input,
				array(
					'email' => 'required|email',
					'password' => 'required',
					)
				);

			if ($validation->passes())
			{
				if ($this->system->setSystemUserByEmail($this->input['email']) AND $this->system->user->hasAdminPermissions('admin'))
				{
					if ($this->system->loginSystemUser($this->input['password']))
					{
						return Redirect::route('admin');
					}
				}
			}
			$this->system->messages->setMessages(array(
					'error' => array(
						'Invalid login details',
						),
					)
				);
		}
		$messages = $this->system->messages->getMessages();
		$input = $this->input;
		return View::make('theme::login', compact('messages', 'input'));
	}

	/**
	 * Controls and displays admin main dashboard.
	 *
	 * @return	Illuminate\View\View
	 */
	public function dashboard()
	{
		$messages = $this->system->messages->getMessages();
		$user = $this->system->user;
		return View::make('theme::sections.dashboard', compact('messages', 'user'));
	}

	/**
	 * Processes array of installed packages into a structured array that
	 * can be used to build the control panel navigation menu .
	 *
	 * @param	Array
	 * @return	Array
	 */
	public function buildControlPanelNavigation(array $packages)
	{
		$navigation_tree = array();
		foreach ($packages as $package)
		{
			if (
				isset($package['details']['has_backend']) AND
				$package['details']['has_backend'] AND
				isset($package['details']['control_panel_menu']) AND
				!empty($package['details']['control_panel_menu'])
				)
			{
				foreach ($package['details']['control_panel_menu'] as $menu_main_heading => $submenu_item)
				{
					foreach ($submenu_item as $submenu_heading => $submenu_details)
					{
						$permission_slugs = explode('|', $submenu_details['permissions']);
						if (isset($permission_slugs[0]) AND !empty($permission_slugs[0]))
						{
							$hi_level_permission = $permission_slugs[0];
							if (isset($permission_slugs[1]))
							{
								$show_menu_item = true;
								$low_level_permission_slugs = explode(',', $permission_slugs[1]);
								foreach ($low_level_permission_slugs as $low_level_perimssion)
								{
									if (!$this->system->user->hasAdminPermissions($hi_level_permission, $low_level_perimssion))
									{
										$show_menu_item = false;
									}
								}
							}
							else
							{
								$show_menu_item = ($this->system->user->hasAdminPermissions($hi_level_permission)) ? true : false;
							}
						}
						else
						{
							$show_menu_item = true;
						}
						if ($show_menu_item)
						{
							if (!isset($navigation_tree[$menu_main_heading]))
							{
								$navigation_tree[$menu_main_heading] = array();
								$navigation_tree[$menu_main_heading][$submenu_heading] = $submenu_details['route'];
							}
							else
							{
								$navigation_tree[$menu_main_heading][$submenu_heading] = $submenu_details['route'];
							}
						}
					}
				}
			}
		}
		return $navigation_tree;
	}
}