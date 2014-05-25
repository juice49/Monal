<?php
/**
 * Admin Controller.
 *
 * Base controller for HTTP/S requests for the systems admin pages.
 *
 * @author	Arran Jacques
 */

use Monal\GatewayInterface;

class AdminController extends BaseController
{
	/**
	 * Constructor.
	 *
	 * @param	Monal\GatewayInterface
	 * @return	Void
	 */
	public function __construct(GatewayInterface $system_gateway)
	{
		parent::__construct($system_gateway);
		$this->control_panel_navigation = $this->buildDashboardMenu();
		View::share('control_panel', $this->control_panel_navigation);
		View::share('system', $this->system);
	}

	/**
	 * Redirect user to the dashboard or login page.
	 *
	 * @return	Illuminate\Http\RedirectResponse
	 */
	public function admin()
	{
		if ($this->system->user->isLoggedIn()) {
			return \Redirect::route('admin.dashboard');
		} else {
			return \Redirect::route('admin.login');
		}
	}

	/**
	 * Controller for HTTP/S requests for the admin login page. Mediates
	 * the requests and outputs a response.
	 *
	 * @return	Illuminate\View\View / Illuminate\Http\RedirectResponse
	 */
	public function login()
	{
		if (!$this->system->user->isGuest()) {
			return \Redirect::route('admin.dashboard');
		}
		if ($this->input) {
			$authentication = $this->system->newAuthRequest();
			$authentication->setUser($this->input['email'], $this->input['password']);
			if ($authentication->validates()) {
				if ($authentication->attempt(true)) {
					return \Redirect::route('admin.dashboard');
				}
			}
			$this->system->messages->add($authentication->messages->get()->toArray());
		}
		$messages = $this->system->messages->get();
		return View::make('login', compact('messages'));
	}

	/**
	 * Controller for HTTP/S requests for the admin logout page. Mediates
	 * the requests and outputs a response.
	 *
	 * @return	Illuminate\Http\RedirectResponse
	 */
	public function logout()
	{
		$this->system->revokeAuth();
		return \Redirect::route('admin.login');
	}

	/**
	 * Controller for HTTP/S requests for the admin dashboard Mediates the
	 * requests and outputs a response.
	 *
	 * @return	Illuminate\View\View / Illuminate\Http\RedirectResponse
	 */
	public function dashboard()
	{
		$messages = $this->system->messages->get();
		return View::make('admin.dashboard', compact('messages'));
	}

	/**
	 * Create an array of menu options for the dashboard control panel
	 * based on the current system user’s permissions.
	 *
	 * @return	Array
	 */
	public function buildDashboardMenu()
	{
		$dashboard_menu = array();
		foreach ($this->system->dashboard->menu() as $category_title => $category_options) {
			foreach ($category_options as $option_title => $option_details) {
				$permission_slugs = explode('|', $option_details['permissions']);
				if (isset($permission_slugs[0]) AND !empty($permission_slugs[0])) {
					$hi_level_permission = $permission_slugs[0];
					if (isset($permission_slugs[1])) {
						$show_menu_item = true;
						$low_level_permission_slugs = explode(',', $permission_slugs[1]);
						foreach ($low_level_permission_slugs as $low_level_perimssion) {
							if (!$this->system->user->hasAdminPermissions($hi_level_permission, $low_level_perimssion)) {
								$show_menu_item = false;
							}
						}
					} else {
						$show_menu_item = ($this->system->user->hasAdminPermissions($hi_level_permission)) ? true : false;
					}
				} else {
					$show_menu_item = true;
				}
				if ($show_menu_item) {
					if (!isset($dashboard_menu[$category_title])) {
						$dashboard_menu[$category_title] = array();
						$dashboard_menu[$category_title][$option_title] = $option_details['route'];
					}
					else{
						$dashboard_menu[$category_title][$option_title] = $option_details['route'];
					}
				}
			}
		}
		return $dashboard_menu;
	}
}