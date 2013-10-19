<?php
/**
 * Admin Controller
 *
 * Base controller for CMS admin pages
 *
 * @author Arran Jacques
 */

use App\Modules\Users\Contracts\UserAuthInterface;
use App\Modules\Messages\Contracts\MessagesInterface;
use App\Modules\Module\Contracts\ModuleManagerInterface;

class AdminController extends BaseController {

	public function __construct(UserAuthInterface $auth, MessagesInterface $message, ModuleManagerInterface $module)
	{
		$this->auth = $auth;
		$this->data = Input::all();

		if (isset($this->data['logout']))
		{
			$this->auth->logout();
		}

		$this->user = $this->auth->adminLoggedIn();

		if ($this->user)
		{
			View::share('current_user', $this->user->user_data);
		}

		$this->message = $message;
		$this->module = $module;
		$this->controlPanelNavigation = $this->buildControlPanelNavigation($this->module->installedModules());
		
		View::share('control_panel', $this->controlPanelNavigation);
	}

	/**
	 * Controls and displays CMS login page
	 *
	 * @return	\Illuminate\View\View
	 */
	public function login()
	{
		if ($this->user)
		{
			return Redirect::route('admin');
		}

		if ($this->data)
		{
			$validation = Validator::make($this->data,
				array(
					'email' => 'required|email',
					'password' => 'required',
					)
				);

			if (!$validation->fails())
			{
				if ($this->auth->adminLogin($this->data['email'], $this->data['password']))
				{
					return Redirect::route('admin');
				}
			}

			$this->message->setMessages(array(
					'error' => array(
						'Invalid login details',
						)
					));
		}
		$messages = $this->message->getMessages();
		$data = $this->data;
		return View::make('theme::login', compact('messages', 'data'));
	}

	/**
	 * Controls and displays CMS main dashboard
	 *
	 * @return	\Illuminate\View\View
	 */
	public function dashboard()
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}
		$messages = $this->message->getMessages();
		$user = $this->user->user_data;
		return View::make('theme::sections.dashboard', compact('messages', 'user'));
	}

	/**
	 * Processes array of installed modules into a structured array
	 * that can be used to build the control panel navigation menu 
	 *
	 * @param	array
	 * @return	array
	 */
	public function buildControlPanelNavigation(array $modules)
	{
		$navigation_tree = array();
		foreach ($modules as $module)
		{
			if (isset($module['details']['has_backend']) && $module['details']['has_backend'])
			{
				if (isset($module['details']['control_panel_heading']) && !empty($module['details']['control_panel_heading']))
				{
					$submenu = (isset($module['details']['control_panel_sub_menu']) && is_array($module['details']['control_panel_sub_menu'])) ? $module['details']['control_panel_sub_menu'] : array();
					if (!isset($navigation_tree[$module['details']['control_panel_heading']]))
					{
						$navigation_tree[$module['details']['control_panel_heading']] = $submenu;
					}
					else
					{
						$navigation_tree[$module['details']['control_panel_heading']] = array_merge($navigation_tree[$module['details']['control_panel_heading']], $submenu);
					}
				}
			}
		}
		return $navigation_tree;
	}
}