<?php namespace App\Modules\Users;
/**
 * Users Module Service Provider
 * 
 * Registers the Messages module with Laravel and set its IOC bindings
 *
 * @author Arran Jacques
 */

use \App\Core\Modules\ModuleServiceProvider;
use \App\Core\Contracts\ServiceProviderInterface;

class UsersServiceProvider extends ModuleServiceProvider implements ServiceProviderInterface {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var		bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return	void
	 */
    public function boot()
    {
        parent::boot('users');
    }

    /**
	 * Register the service provider.
	 *
	 * @return	void
	 */
	public function register()
    {
        parent::register('users');

		$this->app->bind('\App\Modules\Users\Contracts\UserInterface', function()
			{
				return new \App\Modules\Users\User(
						$this->app->make('\App\Modules\Users\Contracts\UserModelInterface')
					);
			});
		$this->app->bind('\App\Modules\Users\Contracts\UserModelInterface', function()
			{
				return new \Users_m;
			});
		$this->app->bind('App\Modules\Users\Contracts\UserAuthInterface', function()
			{
				return new \App\Modules\Users\UserAuth(
						$this->app->make('\App\Modules\Users\Contracts\UserInterface')
					);
			});
    }
}