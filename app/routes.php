<?php

// Core Admin routes.
Monal\API\Routes::addAdminRoute('any', 'login', 'admin.login', 'AdminController@login');
Monal\API\Routes::addAdminRoute('any', 'logout', 'admin.logout', 'AdminController@logout');
Monal\API\Routes::addAdminRoute('any', 'dashboard', 'admin.dashboard', 'AdminController@dashboard');
Monal\API\Routes::addAdminRoute('any', 'packages', 'admin.packages', 'PackagesController@packages');

// Ajax route.
Route::post('ajax', array('as' => 'ajax', 'uses' => 'AJAXController@map'));

// Handle missing routes.
App::missing(function($exception)
{
	return Response::view('errors.missing', [], 404);
});