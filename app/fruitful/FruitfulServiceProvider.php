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
			'Fruitful\Core\Contracts\GatewayInterface',
			function() {
				return new \Fruitful\Core\Gateway;
			}
		);
		$this->app->bind(
			'Fruitful\Core\Contracts\AuthenticationRequestInterface',
			function() {
				return new \Fruitful\Core\AuthenticationRequest;
			}
		);
		$this->app->bind(
			'Fruitful\Core\Contracts\MessagesInterface',
			function() {
				return new \Fruitful\Core\FruitfulMessages;
			}
		);
		$this->app->bind(
			'Fruitful\Core\Contracts\DashboardInterface',
			function() {
				return new \Fruitful\Core\FruitfulDashboard;
			}
		);
		$this->app->bind(
			'Fruitful\Core\Contracts\PermissionsInterface',
			function() {
				return new \Fruitful\Core\FruitfulPermissions;
			}
		);
		$this->app->bind(
			'Fruitful\Repositories\Contracts\AuthenticationRepository',
			function() {
				return new \EloquentAuthenticationRepository;
			}
		);
		$this->app->bind(
			'Fruitful\Repositories\Contracts\UserGroupPermissionsRepository',
			function() {
				return new \EloquentUserGroupPermissionsRepository;
			}
		);
		$this->app->bind(
			'Fruitful\Repositories\Contracts\UserGroupsRepository',
			function() {
				return new \EloquentUserGroupsRepository;
			}
		);
		$this->app->bind(
			'Fruitful\Repositories\Contracts\UsersRepository',
			function() {
				return new \EloquentUsersRepository;
			}
		);
	}
}