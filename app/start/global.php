<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
	$page_template = App::make('Monal\Core\PageTemplate');
	$slug = '';
	foreach (Request::segments() as $segment) {
		$slug .= $segment . '/';
	}
	switch ($code) {
		case 403:
			$page_template->setTitle('403');
			$page_template->setSlug($slug);
			$page = App::make('Monal\Core\Page', array($page_template));
			$view = View::make(Monal\API\App::error403Template(), compact('page'))->render();
			return Response::make($view, 403);
			break;
		case 404:
			$page_template->setTitle('404');
			$page_template->setSlug($slug);
			$page = App::make('Monal\Core\Page', array($page_template));
			$view = View::make(Monal\API\App::error404Template(), compact('page'))->render();
			return Response::make($view, 404);
			break;
		case 500:
			$page_template->setTitle('500');
			$page_template->setSlug($slug);
			$page = App::make('Monal\Core\Page', array($page_template));
			$view = View::make(Monal\API\App::error500Template(), compact('page'))->render();
			return Response::make($view, 500);
			break;
		default:
			$page_template->setTitle($code);
			$page_template->setSlug($slug);
			$page = App::make('Monal\Core\Page', array($page_template));
			$view = View::make(Monal\API\App::errorTemplate(), compact('page'))->render();
			return Response::make($view, $code);
	}
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';
