<?php
namespace Monal;
/**
 * Monal Service Provider.
 *
 * This bootstraps the Monal application with Laravel.
 *
 * @author  Arran Jacques
 */

use Illuminate\Support\ServiceProvider;

class MonalServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 *
	 * @return  Void
	 */
	public function boot()
	{
		\Monal\API\Dashboard::addMenuOption('System', 'Packages', 'packages');
	}

	/**
	 * Register the service provider.
	 *
	 * @return Void
	 */
	public function register()
	{
		// Bind classes to the IOC container.
		$this->app->singleton(
			'Monal\Monal',
			function() {
				return new \Monal\Monal;
			}
		);

		$this->app->singleton(
			'Monal\Repositories\PackagesRepository',
			function() {
				return new \Monal\Repositories\PackagesRepository;
			}
		);
		$this->app->singleton(
			'Monal\Repositories\SettingsRepository',
			function() {
				return new \Monal\Repositories\SettingsRepository;
			}
		);

		// Register Facades
		$this->app['PackagesRepository'] = $this->app->share(function ($app) {
				return \App::make('Monal\Repositories\PackagesRepository');
		});
		$this->app['SettingsRepository'] = $this->app->share(function ($app) {
				return \App::make('Monal\Repositories\SettingsRepository');
		});
		$this->app['FlashMessages'] = $this->app->share(function ($app) {
				return \App::make('Monal\Libraries\FlashMessages');
		});
	}
}