<?php
/**
 * Base Controller.
 *
 * Base controller for requests to the system.
 *
 * @author	Arran Jacques
 */

use Monal\GatewayInterface;

class BaseController extends Controller
{
	/**
	 * Current base system instance
	 *
	 * @var		 Monal\GatewayInterface
	 */
	protected $system;

	/**
	 * Request input data.
	 *
	 * @var		Array
	 */
	public $input;

	/**
	 * Constructor.
	 *
	 * @param	Monal\GatewayInterface
	 * @return	Void
	 */
	public function __construct(GatewayInterface $system_gateway)
	{
		$this->system = $system_gateway;
		$this->input = Input::all();
		View::share('system_user', $this->system->user);
	}
}