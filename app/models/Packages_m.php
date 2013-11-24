<?php 
/**
 * Packages Model
 *
 * Model for the packages table.
 *
 * @author Arran Jacques
 */

class Packages_m extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var		String
	 */
	protected $table = 'packages';

	/**
	 * Find a package by its slug.
	 *
	 * @param	String
	 * @return	Modules_m / Boolean
	 */
	public static function findBySlug($slug)
	{
		$module = self::select('*')->where('slug', '=', $slug)->first();
		if ($module)
		{
			return $module;
		}
		return false;
	}
}