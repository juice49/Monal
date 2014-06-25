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
	$page_template = App::make('Monal\Core\PageTemplate');
	$page_template->setTitle('404');
	$slug = '';
	foreach (Request::segments() as $segment) {
		$slug .= $segment . '/';
	}
	$page_template->setSlug($slug);
	$page = App::make('Monal\Core\Page', array($page_template));
	$view = View::make(Monal\API\App::missingTemplate(), compact('page'))->render();
	return Response::make($view, 404);
});