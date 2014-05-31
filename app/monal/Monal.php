<?php
/**
 * Monal.
 *
 * Static API for directly accessing core system classes.
 *
 * @author	Arran Jacques
 */

class Monal
{
	/**
	 * Return the current instance of the system gateway class.
	 *
	 * @return	Monal\Core\Contracts\GatewayInterface
	 */
	public static function instance()
	{
		return App::make('Monal\GatewayInterface');
	}

	/**
	 * Register a new admin route.
	 *
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	String
	 * @return	Void
	 */
	public static function registerAdminRoute($type, $url, $name, $controller)
	{
		$route = \Config::get('admin.slug') . '/' .$url;
		switch ($type) {
			case 'get':
			case 'GET':
				Route::get($route, array('as' => $name, 'uses' => $controller));
				break;
			case 'post':
			case 'POST':
				Route::post($route, array('as' => $name, 'uses' => $controller));
				break;
			case 'any':
			case 'ANY':
				Route::any($route, array('as' => $name, 'uses' => $controller));
				break;
		}
	}

	/**
	 * Register route logic.
	 *
	 * @param	Closure
	 * @return	Void
	 */
	public static function registerFrontendRouteLogic($closure)
	{
		$system = self::instance();
		array_push($system->route_logic, $closure);
	}

	/**
	 * Register a new dashboard menu option.
	 *
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	String
	 * @return	Void
	 */
	public static function registerMenuOption($category, $title, $route, $permissions = null)
	{
		$system = self::instance();
		$system->dashboard->addMenuOption($category, $title, $route, $permissions);
	}

	/**
	 * Register a new permission set.
	 *
	 * @param	String
	 * @param	String
	 * @param	Array
	 * @return	Void
	 */
	public static function registerPermissionSet($name, $slug, array $permissions = array())
	{
		$system = self::instance();
		$system->permissions->addPermissionSet($name, $slug, $permissions);
	}
}