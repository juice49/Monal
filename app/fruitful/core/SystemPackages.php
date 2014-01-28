<?php namespace Fruitful\Core;
/**
 * System Packages
 *
 * Library for managing system packages.
 *
 * @author	Arran Jacques
 */

class SystemPackages {

	/**
	 * Return an package' details.
	 *
	 * @param	String
	 * @return	Array
	 */
	public function getPackageDetails($pacakge)
	{
		return \Config::get($pacakge . '::details');
	}

	/**
	 * Return the details of each installed package.
	 *
	 * @param	String
	 * @return	Array
	 */
	public function getAllPackageDetails($order = null)
	{
		$packages = array();
		foreach (\Config::get('app.providers') as $provider)
		{
			$package_name = strtolower(explode('\\', $provider)[1]);
			if ($package_details = \Config::get($package_name . '::details'))
			{
				array_push($packages, $package_details);
			}
		}
		return $packages;
	}

	/**
	 * Return an installed package's permission sets.
	 *
	 * @param	String
	 * @return	Array
	 */
	public function getPackagePermissionSets($uri)
	{
		if (isset($uri))
		{
			$package_details = $this->getPackageDetails($uri);
			if (isset($package_details['permission_sets']) AND is_array($package_details['permission_sets']))
			{
				return $package_details['permission_sets'];
			}
		}
		return array();
	}

	/**
	 * Return the permission sets for each installed package.
	 *
	 * @return	Array
	 */
	public function getAllPackagePermissionSets()
	{
		$packages = $this->getInstalledPackages('name');
		$permissions = array();
		foreach ($packages as $package)
		{
			$permissions[$package['name']] = $this->getPackagePermissionSets($package['uri']);
		}
		return isset($permissions) ? $permissions : array();
	}
}