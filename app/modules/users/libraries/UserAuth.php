<?php namespace App\Modules\Users;
/**
 *
 */

use Illuminate\Auth;

class UserAuth implements Contracts\UserAuthInterface {

	public function __construct(\App\Modules\Users\Contracts\UserInterface $user)
	{
		$this->user = $user;
		$this->model = $this->user->model;
	}

	public function login($email = null, $password = null)
	{
		if (!$email or !$password)
		{
			return false;
		}
		return $this->model->checkUserCredentials($email, $password);
	}

	public function loggedIn()
	{
		if (\Auth::check())
		{
			$this->user->data = \Auth::user();
			return $this->user;
		}

		return false;
	}

}