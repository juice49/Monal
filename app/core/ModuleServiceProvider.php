<?php
/**
 * Modules Service Provider
 *
 * This is used to register packages with Laravel allowing a
 * moduler approach to organising code.
 */

namespace App\Core\Modules;
use Illuminate\Support\ServiceProvider;

abstract class ModuleServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		if ($module = $this->getModule(func_get_args()))
        {
            $this->package('app/' . $module, $module, app_path() . '/modules/' . $module);
        }
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		if ($module = $this->getModule(func_get_args()))
        {
            $this->app['config']->package('app/' . $module, app_path() . '/modules/' . $module . '/config');
 
            $routes = app_path() . '/modules/' . $module . '/routes.php';
            if (file_exists($routes)) require $routes;
        }
	}

	/**
	 *
	 */
	public function getModule($args)
    {
        $module = (isset($args[0]) and is_string($args[0])) ? $args[0] : null;
 
        return $module;
    }

}