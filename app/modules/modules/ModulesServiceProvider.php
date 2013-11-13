<?php namespace App\Modules\Modules;
/**
 * Modules Module Service Provider
 * 
 * Registers the Module module with Laravel and set its IOC bindings
 *
 * @author Arran Jacques
 */

use \App\Core\Modules\ModuleServiceProvider;
use \App\Core\Contracts\ServiceProviderInterface;

class ModulesServiceProvider extends ModuleServiceProvider implements ServiceProviderInterface {

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
        parent::boot('modules');
    }

    /**
	 * Register the service provider
	 *
	 * @return	Void
	 */
	public function register()
    {
        parent::register('modules');

        $this->app->bind('App\Modules\Modules\Contracts\ModulesManagerInterface', function()
			{
				return new \App\Modules\Modules\ModulesManager();
			});
    }
}