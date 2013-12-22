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
	 * Return all installed packaged.
	 *
	 * @param	String
	 * @return	Array
	 */
	public function getInstalledPackages($order = null)
	{
		$order_by = isset($order) ? $order : 'name';
		$packages = \Packages_m::select('*')->orderBy($order_by)->get();
		return ($packages) ? $packages->toArray() : array();
	}

	/**
	 * Return an installed package's details.
	 *
	 * @param	String
	 * @return	Array
	 */
	public function getPackageDetails($uri)
	{
		return isset($uri) ? \Config::get($uri . '::details') : array();
	}

	/**
	 * Return the details of each installed package.
	 *
	 * @param	String
	 * @return	Array
	 */
	public function getAllPackageDetails($order = null)
	{
		$packages = $this->getInstalledPackages($order);
		foreach ($packages as &$package)
		{
			$details = $this->getPackageDetails($package['uri']);
			unset(
				$details['name'],
				$details['uri']
				);
			$package['details'] = $details;
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