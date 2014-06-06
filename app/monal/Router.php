<?php
/**
 * Router.
 *
 * @author	Arran Jacques
 */

class Router
{
	/**
	 * Check if the route matches any deinfed route logic. Is so
	 * intercept the route and return whatever is specified in the logic.
	 *
	 * @param	Array
	 * @return	Mixed
	 */
	public static function intercept(array $url_segments)
	{
		if (!empty($url_segments)) {
			if ($admin_route = self::adminRoute($url_segments)) {
				return ($admin_route === true) ? false : $admin_route;
			}
		}
		$system = \Monal::instance();
		foreach ($system->route_logic as $route_logic) {
			if ($matched = $route_logic($url_segments)) {
				return $matched;
			}
		}
		return false;
	}

	/**
	 * Check if a route is an Admin route. If so check the user has valid
	 * credentials to access the Admin dashboard.
	 *
	 * @param	Array
	 * @return	Boolean / Illuminate\Http\RedirectResponse
	 */
	private static function adminRoute(array $url_segments)
	{
		$admin_slug = \Config::get('admin.slug');
		if ($admin_slug AND preg_match('/^[a-z0-9\-]+$/i', $admin_slug)) {
			// Is the route trying to access the admin area of the system.
			if ($url_segments[0] == $admin_slug) {
				// If it is check the user is logged in and has valid credentials.
				$system = \Monal::instance();
				$grant_access = $system->attemptAuthFromSession(true);
				if (count($url_segments) == 1) {
					return $grant_access ? Redirect::route('admin.dashboard') : Redirect::route('admin.login');
				} else {
					if (!$grant_access AND \Request::url() != \URL::route('admin.login')) {
						return Redirect::route('admin.login');
					}
				}
				return true;
			}
		}
		return false;
	}
}