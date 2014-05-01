<?php
namespace Fruitful\Core;
/**
 * Dashboard.
 *
 * Add to and expand the Admin dashboard.
 *
 * @author	Arran Jacques
 */

class Dashboard
{
	/**
	 * Dashboard menu options in Array form.
	 *
	 * @var		Array
	 */
	protected $menu = array();

	/**
	 * Return the dashboard's menu options.
	 *
	 * @return	Array 
	 */
	public function menu()
	{
		return $this->menu;
	}

	/**
	 * Add a menu option to the dashboard.
	 *
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	String
	 * @return	Void
	 */
	public function addMenuOption($category, $title, $route, $permissions = null)
	{
		if (!isset($this->menu[$category])) {
			$this->menu[$category] = array();
		}
		$this->menu[$category][$title] = array(
			'route' => $route,
			'permissions' => $permissions,
		);
	}
}