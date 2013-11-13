<?php namespace App\Modules\Modules\Contracts;

interface ModulesManagerInterface {

	/**
	 * Get all installed modules
	 *
	 * @return	Array
	 */
	public function getInstalledModules();
}