<?php
/**
 * Base Controller.
 *
 * Base controller for all system pages.
 *
 * @author	Arran Jacques
 */

use Fruitful\GatewayInterface;

class BaseController extends Controller
{
	/**
	 * Instance of class implementing GatewayInterface.
	 *
	 * @var		 Fruitful\GatewayInterface
	 */
	protected $system;

	/**
	 * Input data.
	 *
	 * @var		Array
	 */
	public $input;

	/**
	 * Constructor.
	 *
	 * @param	Fruitful\GatewayInterface
	 * @return	Void
	 */
	public function __construct(GatewayInterface $system_gateway)
	{
		$this->system = $system_gateway;
		$this->input = Input::all();
		View::share('system_user', $this->system->user);
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return	Void
	 */
	protected function setupLayout()
	{
		if (!is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}
}