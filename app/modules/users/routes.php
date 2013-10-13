<?php

Route::any('/admin/users', array('as' => 'admin.users', 'uses' => 'UsersController@users'));
Route::any('/admin/users/groups', array('as' => 'admin.users.groups', 'uses' => 'UsersController@userGroups'));
Route::any('/admin/users/groups/add', array('as' => 'admin.users.groups.add', 'uses' => 'UsersController@addUserGroup'));