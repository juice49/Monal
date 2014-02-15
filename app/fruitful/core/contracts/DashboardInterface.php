<?php
namespace Fruitful\Core\Contracts;
/**
 * Dashboard Interaface.
 *
 * Contract for system dashboard class.
 *
 * @author	Arran Jacques
 */

interface DashboardInterface
{
	/**
	 * Return the dashboard's menu options.
	 *
	 * @return	Array 
	 */
	public function menu();

	/**
	 * Add a menu option to the dashboard.
	 *
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	String
	 * @return	Void
	 */
	public function addMenuOption($category, $title, $route, $permissions = null);
}