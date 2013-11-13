<?php namespace App\Modules\Messages;
/**
 * Messages Module Service Provider
 * 
 * Registers the Messages module with Laravel and set its IOC bindings
 *
 * @author Arran Jacques
 */

use App\Core\Modules\ModuleServiceProvider;
use App\Core\Contracts\ServiceProviderInterface;

class MessagesServiceProvider extends ModuleServiceProvider implements ServiceProviderInterface {

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
        parent::boot('messages');
    }

    /**
	 * Register the service provider
	 *
	 * @return	Void
	 */
	public function register()
    {
        parent::register('messages');

		$this->app->bind('App\Modules\Messages\Contracts\MessagesInterface', function()
			{
				return new \App\Modules\Messages\Messages();
			});
    }
}