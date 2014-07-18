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
	return handleException($exception, $code);
});

// Listen for Eloquent's `ModelNotFoundException` and map it to a 404 error
App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $exception)
{
	return handleException($exception, 404);
});

function handleException(Exception $exception, $code)
{
	// Log the error.
	Log::error($exception);

	// A 404 error should always return the 404 view, even with debug mode on	
	if (!Config::get('app.debug') || $code == 404)
	{
		// Create a new page template.
		$page_template = App::make('Monal\Models\PageTemplate');

		// Build the pages URI from the request URL.
		$url_segments = Request::segments();
		$uri = '';
		foreach ($url_segments as $segment) {
			$uri .= $segment . '/';
		}

		// Set the page template's properties.
		$page_template->setTitle($code);
		$page_template->setSlug(end($url_segments));
		$page_template->setURI($uri);

		// Does this error code have a specialised view?
		$error_has_view = in_array($code, [403, 404, 500]);
		$function_name = $error_has_view
			? 'error' . $code . 'Template'
			: 'errorTemplate';

		// Create a new page and render its view, and then output a response.
		$page = App::make('Monal\Models\Page', array($page_template));
		$view = View::make(Monal\API\App::$function_name(), compact('exception', 'page'))->render();
		return Response::make($view, $code);
	}
}

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
