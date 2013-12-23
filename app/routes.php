<?php
App::singleton('Fruitful\Core\Contracts\GatewayInterface', function()
{
	return new Fruitful\Core\Gateway();
});

Route::any('login', array('as' => 'admin.login', 'uses' => 'AdminController@login'));
Route::any('admin', array('as' => 'admin', 'before' => 'admin', 'uses' => 'AdminController@dashboard'));
Route::post('ajax', array('as' => 'ajax', 'uses' => 'AJAXController@map'));
