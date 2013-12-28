<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the core database seeds.
	 *
	 * @return	Void
	 */
	public function run()
	{
		Eloquent::unguard();

		UserGroups_m::create(array(
			'name' => 'Administrator',
			'active' => '1'
			));

		UserGroupPermissions_m::create(array(
			'group' => '1',
			'admin' => '1',
			'admin_permissions' => null,
			));
	}

}