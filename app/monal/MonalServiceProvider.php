<?php
namespace Monal;
/**
 * Monal Service Provider.
 *
 * Bootstrap the Monal application.
 *
 * @author	Arran Jacques
 */

use Illuminate\Support\ServiceProvider;

class MonalServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 *
	 * @return	Void
	 */
	public function boot()
	{
		\Monal::registerMenuOption('System', 'Packages', 'packages');
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
			'Monal\GatewayInterface',
			function() {
				return new \Monal\Gateway;
			}
		);
		$this->app->bind(
			'Monal\Core\Contracts\MessagesInterface',
			function() {
				return new \Monal\Core\Messages;
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
		$this->app['packagesrepository'] = $this->app->share(function ($app) {
				return \App::make('Monal\Repositories\PackagesRepository');
		});
		$this->app->booting(function () {
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('PackagesRepository', 'Monal\Repositories\Facades\PackagesRepository');
		});

		$this->app['settingsrepository'] = $this->app->share(function ($app) {
				return \App::make('Monal\Repositories\SettingsRepository');
		});
		$this->app->booting(function () {
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('SettingsRepository', 'Monal\Repositories\Facades\SettingsRepository');
		});

		$this->app['apipackages'] = $this->app->share(function ($app) {
				return \App::make('Monal\API\Packages');
		});
		$this->app->booting(function () {
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Packages', 'Monal\API\Facades\Packages');
		});
	}
}