<?php
/**
 *
 */

class AdminController extends BaseController {

	public function __construct(App\Modules\Users\Contracts\UserAuthInterface $auth)
	{
		$this->auth = $auth;
		$this->user = $this->auth->loggedIn();
	}

	public function login()
	{
		if ($this->user)
		{
			return Redirect::route('admin');
		}

		$data = Input::all();

		if($data)
		{
			if ($this->auth->login($data['email'], $data['password']))
			{
				return Redirect::route('admin');
			}
		}

		return View::make('theme::login');
	}

	public function dashboard()
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}
		return 'admin';
	}

	public function module($module = null)
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}

		if (!$module or $module != 'users' or !$this->user->hasPrivileges())
		{
			return Redirect::route('admin');
		}

		return $module;
	}

}