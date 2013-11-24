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
	 * Get all installed packages.
	 *
	 * @return	Array
	 */
	public function getInstalledPackages()
	{
		$packages = \Packages_m::select('*')->orderBy('name')->get();
		if ($packages)
		{
			foreach ($packages as &$package)
			{
				$details = \Config::get($package->slug . '::details');
				unset(
					$details['name'],
					$details['slug']
					);
				$package->details = $details;
			}
			return $packages->toArray();
		}
		return array();
	}
}