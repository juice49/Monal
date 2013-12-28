<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_group_permissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('group')->nullable();
			$table->boolean('admin')->nullable();
			$table->text('admin_permissions')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_group_permissions');
	}

}
