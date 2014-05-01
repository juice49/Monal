<?php
namespace Fruitful;
/**
 * Fruitful Service Provider.
 *
 * Bootstrap the Fruitful application.
 *
 * @author	Arran Jacques
 */

use Illuminate\Support\ServiceProvider;

class FruitfulServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 *
	 * @return	Void
	 */
	public function boot()
	{
	}

	/**
	 * Register the service provider.
	 *
	 * @return Void
	 */
	public function register()
	{
		$this->app->singleton(
			'Fruitful\GatewayInterface',
			function() {
				return new \Fruitful\Gateway;
			}
		);
		$this->app->bind(
			'Fruitful\Core\Contracts\MessagesInterface',
			function() {
				return new \Fruitful\Core\Messages;
			}
		);
	}
}