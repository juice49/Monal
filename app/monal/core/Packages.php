<?php
namespace Monal\Core;
/**
 * Packages.
 *
 * This is Monal’s packages API, which provides methods for
 * installing and uninstalling packages, and reading information on
 * the packages registered with the system.
 *
 * @author  Arran Jacques
 */

class Packages
{
	/**
	 * Return a collection of all Monal system packages, wether installed
	 * or not.
	 *
	 * @return  Illuminate\Support\Collection
	 */
	public function monalPackages()
	{
		$packages = \App::make('Illuminate\Support\Collection');
		$app = \App::make('Illuminate\Foundation\Application');
		foreach (\Config::get('app.providers') as $provider) {
			$service_provider = \App::make($provider, array($app));
			if ($service_provider instanceof \Monal\MonalPackageServiceProvider) {
				$package_details = $service_provider->packageDetails();
				$package = array(
					'name' => isset($package_details['name']) ? $package_details['name'] : null,
					'author' => isset($package_details['author']) ? $package_details['author'] : null,
					'version' => isset($package_details['version']) ? $package_details['version'] : null,
					'service_provider' => $service_provider,
				);
				$packages->put($service_provider->packageNamespace(), $package);
			}
		}
		return $packages;
	}

	/**
	 * Return a collection of all uninstalled Monal system packages.
	 *
	 * @return  Illuminate\Support\Collection
	 */
	public function uninstalledPackages()
	{
		$packages = \App::make('Illuminate\Support\Collection');
		foreach ($this->monalPackages() as $package) {
			if (!$this->isInstalled($package['service_provider']->packageNamespace())) {
				$packages->put($package['service_provider']->packageNamespace(), $package);
			}
		}
		return $packages;
	}

	/**
	 * Return a collection of all installed Monal system packages.
	 *
	 * @return  Illuminate\Support\Collection
	 */
	public function installedPackages()
	{
		$packages = \App::make('Illuminate\Support\Collection');
		$i = 0;
		foreach ($this->monalPackages() as $package) {
			if ($this->isInstalled($package['service_provider']->packageNamespace())) {
				$packages->put($i, $package);
			}
			$i++;
		}
		return $packages;
	}

	/**
	 * Check if a Monal system package is installed.
	 *
	 * @param   String
	 * @return  Boolean
	 */
	public function isInstalled($package_namespace)
	{
		return (\PackagesRepository::retrieveByName($package_namespace)) ? true : false;
	}

	/**
	 * Install a Monal system package.
	 *
	 * @param   String
	 * @return  Boolean
	 */
	public function install($package_namespace)
	{
		$packages = $this->monalPackages();
		echo $package_namespace;
		if (isset($packages[$package_namespace])) {
			echo 'BB';
			try {
				if ($packages[$package_namespace]['service_provider']->install()) {
					$package_model = \PackagesRepository::newModel();
					$package_model->setName($package_namespace);
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
	 * Publish a Monal system package’s assets.
	 *
	 * @param   String
	 * @param   String
	 * @param   String
	 */
	public function publishAssets($vendor, $package, $assets_dir)
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