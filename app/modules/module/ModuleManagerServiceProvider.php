<?php namespace App\Modules\Module;
/**
 * Module Module Service Provider
 * 
 * Registers the Module module with Laravel and set its IOC bindings
 *
 * @author Arran Jacques
 */

use \App\Core\Modules\ModuleServiceProvider;
use \App\Core\Contracts\ServiceProviderInterface;

class ModuleManagerServiceProvider extends ModuleServiceProvider implements ServiceProviderInterface {

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
        parent::boot('module');
    }

    /**
	 * Register the service provider.
	 *
	 * @return	void
	 */
	public function register()
    {
        parent::register('module');

        $this->app->bind('App\Modules\Module\Contracts\ModuleManagerInterface', function()
			{
				return new \App\Modules\Module\ModuleManager();
			});
    }
}