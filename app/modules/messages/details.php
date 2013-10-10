<?php
/**
 *
 */

class Module_Messages extends Module implements ModuleInterface {

	public function info()
	{
		return array(
				'name' => 'Messages',
				'description' => array(
						'en' => 'Manages app messages',
					),
				'has_backend' => false,
				'control_panel_heading' => false,
				'sub_menu' => false,
			);
	}
}