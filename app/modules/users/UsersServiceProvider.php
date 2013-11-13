<?php namespace App\Modules\Users;
/**
 * Users Module Service Provider
 * 
 * Registers the Users module with Laravel and set its IOC bindings
 *
 * @author Arran Jacques
 */

use \App\Core\Modules\ModuleServiceProvider;
use \App\Core\Contracts\ServiceProviderInterface;

class UsersServiceProvider extends ModuleServiceProvider implements ServiceProviderInterface {

	/**
	 * Indicates if loading of the provider is deferred
	 *
	 * @var		Boolean
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events
	 *
	 * @return	Void
	 */
    public function boot()
    {
        parent::boot('users');
    }

    /**
	 * Register the service provider
	 *
	 * @return	Void
	 */
	public function register()
    {
        parent::register('users');

        $this->app->bind('App\Modules\Users\Contracts\UsersManagerInterface', function()
			{
				return new \App\Modules\Users\UsersManager();
			});
		$this->app->bind('App\Modules\Users\Contracts\UserAuthInterface', function()
			{
				return new \App\Modules\Users\UserAuth(
						$this->app->make('\App\Modules\Users\Contracts\UserInterface')
					);
			});
    }
}