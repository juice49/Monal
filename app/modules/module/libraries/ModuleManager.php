<?php namespace App\Modules\Module;
/**
 * Module
 *
 * Library for managing cms modules 
 *
 * @author Arran Jacques
 */

use Illuminate\Support\MessageBag;

class ModuleManager implements Contracts\ModuleManagerInterface {

	/**
	 * Return all installed modules
	 *
	 * @return	array
	 */
	public function installedModules()
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