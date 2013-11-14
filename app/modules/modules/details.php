<?php
/**
 * Modules Module
 *
 * @author Arran Jacques
 */

use App\Core\Contracts\ModuleInterface;

class Module_Modules extends Module implements ModuleInterface {

	/**
	 * Return module's details
	 *
	 * @return	Array
	 */
	public function info()
	{
		return array(
				'name' => 'Modules',
				'description' => array(
						'en' => 'Install, unistall and update system modules',
					),
				'has_backend' => true,
				'control_panel_menu' => array(
						'System' => array(
								'Modules' => '/modules',
							),
					),
			);
	}
}