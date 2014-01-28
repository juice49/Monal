<?php
/**
 * Base Controller.
 *
 * Base controller for all system pages.
 *
 * @author	Arran Jacques
 */

use Fruitful\Core\Contracts\GatewayInterface;

class BaseController extends Controller {

	/**
	 * Instance of class that implements the GatewayInterface interface.
	 *
	 * @var		Fruitful\Core\Contracts\GatewayInterface
	 */
	protected $system;

	/**
	 * Input data.
	 *
	 * @var		Array
	 */
	public $input;

	/**
	 * Initialise class.
	 *
	 * @param	Fruitful\Core\Contracts\GatewayInterface
	 * @return	Void
	 */
	public function __construct(GatewayInterface $system_gateway)
	{
		$this->system = $system_gateway;
		$this->input = Input::all();
		View::share('system_user', $this->system->user);

		// Allow alpha and space characters.
		Validator::extend('alpha_space', function($attribute, $value, $parameters)
		{
			return (preg_match('/^[a-z ]+$/i', $value)) ? true : false;
		});
		// Allow numeric and space characters.
		Validator::extend('num_space', function($attribute, $value, $parameters)
		{
			return (preg_match('/^[0-9 ]+$/', $value)) ? true : false;
		});
		// Allow alpha, numeric and space characters.
		Validator::extend('alpha_num_space', function($attribute, $value, $parameters)
		{
			return (preg_match('/^[a-z0-9 ]+$/i', $value)) ? true : false;
		});
		// Allow alpha, numeric, hypens and space characters. Must also contain at least 1 letter.
		Validator::extend('name', function($attribute, $value, $parameters)
		{
			return (preg_match('/^[a-z .\-]+$/i', $value) AND preg_match('/[a-zA-Z]/', $value)) ? true : false;
		});
		// Allow alpha, numeric, hypens, underscores and space characters.
		Validator::extend('username', function($attribute, $value, $parameters)
		{
			return (preg_match('/^[a-z0-9 .\-_]+$/i', $value)) ? true : false;
		});
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return	Void
	 */
	protected function setupLayout()
	{
		if (!is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
}