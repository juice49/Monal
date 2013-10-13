<?php
/**
 *
 */

class Module_Users extends Module implements ModuleInterface {

	public function info()
	{
		return array(
				'name' => 'Users',
				'description' => array(
						'en' => 'Provides functionality to manage CMS and site users, and manage user permissions',
					),
				'has_backend' => true,
				'control_panel_heading' => 'Users',
				'control_panel_sub_menu' => array(
						'Users' => '/users',
						'User Groups' => '/users/groups',
						'User Privileges' =>  '/users/privileges',
					),
			);
	}
}