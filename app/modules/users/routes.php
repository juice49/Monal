<?php

Route::any('/admin/users', array('as' => 'admin.users', 'uses' => 'UsersController@users'));
Route::any('/admin/users/add', array('as' => 'admin.users.add', 'uses' => 'UsersController@addUser'));
Route::any('/admin/users/edit/{user_id}', array('as' => 'admin.users.edit', 'uses' => 'UsersController@editUser'));
Route::any('/admin/users/groups', array('as' => 'admin.users.groups', 'uses' => 'UsersController@userGroups'));
Route::any('/admin/users/groups/add', array('as' => 'admin.users.groups.add', 'uses' => 'UsersController@addUserGroup'));
Route::any('/admin/users/groups/edit/{group_id}', array('as' => 'admin.users.groups.edit', 'uses' => 'UsersController@editUserGroup'));