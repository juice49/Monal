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
	private static function system()
	{
		return App::make('Fruitful\Core\Contracts\GatewayInterface');
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
		$system = self::system();
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
		$system = self::system();
		$system->permissions->addPermissionSet($name, $slug, $permissions);
	}
}