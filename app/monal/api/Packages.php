<?php
namespace Monal\API;
/**
 * Packages.
 *
 * @author	Arran Jacques
 */

class Packages
{
	/**
	 * Return an array containing details all Monal system packages,
	 * wether installed or not.
	 *
	 * @return	Array
	 */
	public function systemPackages()
	{
		$packages = \App::make('Illuminate\Database\Eloquent\Collection');
		foreach (\Config::get('app.providers') as $provider) {
			$service_provider = \App::make($provider, array(\App::make('Illuminate\Foundation\Application')));
			if ($service_provider instanceof \Monal\MonalPackageServiceProvider) {
				$package = $service_provider->packageDetails();
				$package['service_provider'] = $service_provider;
				$packages->put($service_provider->packageNamespace(), $package);
			}
		}
		return $packages;
	}

	/**
	 * Return an array of all pacakges registered with the system but that
	 * are not installed.
	 *
	 * @return	Array
	 */
	public function unistalledPackages()
	{
		$packages = \App::make('Illuminate\Database\Eloquent\Collection');
		foreach (\Config::get('app.providers') as $provider) {
			$service_provider = \App::make($provider, array(\App::make('Illuminate\Foundation\Application')));
			if ($service_provider instanceof \Monal\MonalPackageServiceProvider) {
				if (!\PackagesRepository::retrieveByName($service_provider->packageNamespace())) {
					$packages->put($service_provider->packageNamespace(), $service_provider->packageDetails());
				}
			}
		}
		return $packages;
	}

	/**
	 * Check if a package is installed.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function isInstalled($package)
	{
		return (\PackagesRepository::retrieveByName($package)) ? true : false;
	}

	/**
	 * Install a package to the system.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function install($package)
	{
		$packages = $this->systemPackages();
		if (isset($packages[$package])) {
			try {
				if ($packages[$package]['service_provider']->install()) {
					$package_model = \PackagesRepository::newModel();
					$package_model->setName($package);
					if (\PackagesRepository::write($package_model)) {
						return true;
					}
				}
			} catch (Exception $e) {
				return false;
			}
		}
		return false;
	}

	/**
	 * Publish a package's assets.
	 *
	 * @param	String
	 * @param	String
	 * @param	String
	 */
	public static function publishAssets($vendor, $package, $assets_dir)
	{
		$vendor = trim(strtolower($vendor), '/');
		$package = trim(strtolower($package), '/');
		if (!is_dir(public_path() . '/packages')) {
			mkdir(public_path() . '/packages');
		}
		if (!is_dir(public_path() . '/packages/' . $vendor)) {
			mkdir(public_path() . '/packages/' . $vendor);
		}
		if (!is_dir(public_path() . '/packages/' . $vendor . '/' . $package)) {
			mkdir(public_path() . '/packages/' . $vendor . '/' . $package);
		}
		\Resource::cloneDirecotry($assets_dir, public_path() . '/packages/' . $vendor . '/' . $package);
	}
}