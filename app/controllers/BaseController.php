<?php
/**
 * Base Controller.
 *
 * This is the base controller for all requests to the system.
 *
 * @author	Arran Jacques
 */

use Monal\Monal;

class BaseController extends Controller
{
	/**
	 * The current system instance.
	 *
	 * @var		 Monal\Monal
	 */
	protected $system;

	/**
	 * An array of input data from the request.
	 *
	 * @var		Array
	 */
	public $input;

	/**
	 * Constructor.
	 *
	 * @param	Monal\Monal
	 * @return	Void
	 */
	public function __construct(Monal $system)
	{
		$this->system = $system;
		$this->input = Input::all();
		View::share('system_user', $this->system->user);
	}
}