<?php
/**
 *
 */

class Module_Module extends Module implements ModuleInterface {

	public function info()
	{
		return array(
				'name' => 'Module',
				'description' => array(
						'en' => 'Provides functionality to manage CMS modules',
					),
				'has_backend' => true,
				'control_panel_heading' => 'Modules',
				'sub_menu' => false,
			);
	}
}