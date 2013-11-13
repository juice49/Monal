<?php namespace App\Modules\Modules;
/**
 * Modules Manager
 *
 * Library for managing CMS modules 
 *
 * @author Arran Jacques
 */

use App\Modules\Modules\Contracts\ModulesManagerInterface;

class ModulesManager implements ModulesManagerInterface {

	/**
	 * Get all installed modules
	 *
	 * @return	Array
	 */
	public function getInstalledModules()
	{
		$modules = \Modules_m::select('*')->orderBy('module')->get()->toArray();
		foreach ($modules as &$item)
		{
			$path = base_path() . '/app/modules/' . $item['module'] . '/details.php';
			if (file_exists($path))
			{
				$class = 'Module_' . $item['module'];
				$module = new $class();
				$item['details'] = $module->info();
			}
		}
		return $modules;
	}
}