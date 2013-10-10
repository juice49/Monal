<?php 
/**
 *
 */

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use App\Modules\Users\Contracts\UserModelInterface;

class Modules_m extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 protected $table = 'modules';

}