<?php
namespace Monal\Models;
/**
 * Authentication Request.
 *
 * A model for a authentication request to the system.
 *
 * @author	Arran Jacques
 */

class AuthenticationRequest
{
	/**
	 * The authentication request's messages.
	 *
	 * @var		Monal\Core\Contracts\MessagesInterface
	 */
	public $messages;

	/**
	 * The system's authentication repository.
	 *
	 * @var		Monal\Repositories\Contracts\AuthenticationRepository
	 */
	protected $repository;

	/**
	 * Email address to authenticate.
	 *
	 * @var		 String
	 */
	private $email;

	/**
	 * Password to authenticate.
	 *
	 * @var		 String
	 */
	private $password;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->messages = \App::make('Monal\Core\Contracts\MessagesInterface');
		$this->repository = \App::make('EloquentAuthenticationRepository');
	}

	/**
	 * Set the user's authentication details.
	 *
	 * @param	String
	 * @param	String
	 * @return	Void
	 */
	public function setUser($email, $password)
	{
		$this->email = $email;
		$this->password = $password;
	}

	/**
	 * Check if the user details provided are valid values for an
	 * authentication request.
	 *
	 * @return	Boolean
	 */
	public function validates()
	{
		$validation = \Validator::make(
			array(
				'email' => $this->email,
				'password' => $this->password,
			),
			array(
				'email' => 'required|email',
				'password' => 'required',
			)
		);
		if (!$validation->passes()) {
			$this->messages->add(
				array(
					'error' => array(
						'Login failed.'
					)
				)
			);
			return false;
		}
		return true;
	}

	/**
	 * Attempt to authenticate the user with the system and log them in.
	 *
	 * @param	Boolean
	 * @return	Boolean
	 */
	public function attempt($remember = false, $as_admin = false)
	{
		$authenticated = false;
		if ($user = $this->repository->retrieve($this->email)) {
			if ($user->active) {
				if ($as_admin) {
					if ($user->group_details->group_permissions->admin) {
						$authenticated = \Auth::attempt(array('email' => $this->email, 'password' => $this->password), $remember) ? true : false;
					}
				} else {
					$authenticated = \Auth::attempt(array('email' => $this->email, 'password' => $this->password), $remember) ? true : false;
				}
			}
		}
		$this->messages->add(
			array(
				'error' => array(
					'Login failed.'
				)
			)
		);
		return $authenticated;
	}
}