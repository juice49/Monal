<?php 
/**
 * Modules
 *
 * Model for the modules table
 *
 * @author Arran Jacques
 */

class Modules_m extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var String
	 */
	 protected $table = 'modules';

	 /**
	  * Find a module by its slug
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