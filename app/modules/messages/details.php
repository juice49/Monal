<?php
/**
 * Messages Module
 *
 * @author Arran Jacques
 */

use App\Core\Contracts;

class Module_Messages extends Module implements ModuleInterface {

	/**
	 * Return module's details
	 *
	 * @return	Array
	 */
	public function info()
	{
		return array(
				'name' => 'Messages',
				'description' => array(
						'en' => 'Set and retrieve messages',
					),
				'has_backend' => false,
				'control_panel_menu' => false,
			);
	}
}