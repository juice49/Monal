<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	$system = App::make('Fruitful\Core\Contracts\GatewayInterface');
	$system->attemptAuthFromSession();

	// Check if the installation files are present. If they arr then run
	// the installation process.
	if (file_exists(app_path() . '/installation/routes.php'))
	{
		require app_path() . '/installation/routes.php';
		require app_path() . '/installation/Installer.php';
		require app_path() . '/installation/InstallationController.php';

		View::addLocation(app('path') . '/installation/views');
		View::addNamespace('installation', app('path') . '/installation/views');

		$installer = new \Installer;
		switch ($step = $installer->getInstallationStep())
		{
			case 'ERROR':
				return 'There appears to be an error with the installation process';
				break;
			case 'step1':
				if (Request::url() != URL::route('installation.database'))
				{
					return Redirect::route('installation.database');
				}
				break;
			case 'step2':
				if (Request::url() != URL::route('installation.user'))
				{
					return Redirect::route('installation.user');
				}
				break;
			case 'step3':
				if (Request::url() != URL::route('installation.remove'))
				{
					return Redirect::route('installation.remove');
				}
				break;
		}
	}
});


App::after(function($request, $response)
{

});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('admin', function()
{
	if (Request::url() != URL::route('admin.login'))
	{
		$system = App::make('Fruitful\Core\Contracts\GatewayInterface');
		if (!$system->attemptAuthFromSession(true))
		{
			return Redirect::route('admin.login');
		}
	}
});
Route::when('admin/*', 'admin');

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});