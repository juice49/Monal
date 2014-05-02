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
	}

	/**
	 * Register the service provider.
	 *
	 * @return Void
	 */
	public function register()
	{
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
	}
}