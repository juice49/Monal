<?php
/**
 * Fruitful.
 *
 * Static API for directly accessing core system classes.
 *
 * @author	Arran Jacques
 */

class Fruitful
{
	/**
	 * Return the current instance of the system gateway class.
	 *
	 * @return	Fruitful\Core\Contracts\GatewayInterface
	 */
	public static function instance()
	{
		return App::make('Fruitful\GatewayInterface');
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