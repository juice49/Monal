<?php
/**
 * Admin Controller.
 *
 * This is the base controller for requests to the system's various
 * admin dashboards.
 *
 * @author  Arran Jacques
 */

use Monal\Monal;

class AdminController extends BaseController
{
    /**
     * Constructor.
     *
     * @param   Monal\Monal
     * @return  Void
     */
    public function __construct(Monal $system)
    {
        parent::__construct($system);
        $this->control_panel_navigation = $this->buildDashboardMenu();
        View::share('control_panel', $this->control_panel_navigation);
        View::share('system', $this->system);
    }

    /**
     * Redirect user to the dashboard or login page.
     *
     * @return  Illuminate\Http\RedirectResponse
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
     * Process requests to the login page for the admin dashboard and
     * output a response.
     *
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        if (!$this->system->user->isGuest()) {
            return \Redirect::route('admin.dashboard');
        }
        if ($this->input) {
            $remember = isset($this->input['remember_me']);
            $authentication = $this->system->newAuthRequest();
            $authentication->setUser($this->input['email'], $this->input['password']);
            if ($authentication->validates()) {
                if ($authentication->attempt($remember, true)) {
                    return \Redirect::route('admin.dashboard');
                }
            }
            $this->system->messages->merge($authentication->messages());
        }
        $messages = $this->system->messages;
        return View::make('login', compact('messages'));
    }

    /**
     * Process requests to logout the current system user and output a
     * response.
     *
     * @return  Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $this->system->revokeAuth();
        return \Redirect::route('admin.login');
    }

    /**
     * Process requests to the admin dashboard and output a response.
     *
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        $uninstalled_packages = $this->system->packages->uninstalledPackages();
        $messages = $this->system->messages;
        return View::make('admin.dashboard', compact('messages', 'uninstalled_packages'));
    }

    /**
     * Create an array of menu options for the dashboard control panel
     * based on the current system user’s permissions.
     *
     * @return  Array
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