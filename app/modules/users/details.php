<?php
/**
 * Users Module
 *
 * @author Arran Jacques
 */

use App\Core\Contracts\ModuleInterface;

class Module_Users extends Module implements ModuleInterface {

	/**
	 * Return module's details
	 *
	 * @return	Array
	 */
	public function info()
	{
		return array(
				'name' => 'Users',
				'description' => array(
						'en' => 'Create, read, update, delete and manage system users and user groups',
					),
				'has_backend' => true,
				'control_panel_menu' => array(
						'Users' => array(
								'Users' => '/users',
								'User Groups' => '/users/groups',
							),
					),
			);
	}
}