<?php

// Core Admin routes.
Monal::registerAdminRoute('any', 'login', 'admin.login', 'AdminController@login');
Monal::registerAdminRoute('any', 'logout', 'admin.logout', 'AdminController@logout');
Monal::registerAdminRoute('any', 'dashboard', 'admin.dashboard', 'AdminController@dashboard');

// Ajax route.
Route::post('ajax', array('as' => 'ajax', 'uses' => 'AJAXController@map'));

// Handle 404 errors
App::missing(function($exception)
{
	return '404';
});