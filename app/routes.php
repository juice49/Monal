<?php
App::singleton('Fruitful\Core\Contracts\GatewayInterface', function()
{
	return new Fruitful\Core\Gateway();
});

Route::any('admin/login', array('as' => 'admin.login', 'uses' => 'AdminController@login'));
Route::post('admin/logout', array('as' => 'admin.logout', 'uses' => 'AdminController@logout'));
Route::any('admin/dashboard', array('as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard'));
Route::post('ajax', array('as' => 'ajax', 'uses' => 'AJAXController@map'));
