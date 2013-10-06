<?php
/**
 * Admin Controller
 *
 * Base controller for CMS admin pages
 *
 * @author Arran Jacques
 */

use App\Modules\Users\Contracts\UserAuthInterface;
use App\Modules\Messages\Contracts\MessagesInterface;

class AdminController extends BaseController {

	public function __construct(UserAuthInterface $auth, MessagesInterface $message)
	{
		$this->auth = $auth;
		$this->data = Input::all();
		if(isset($this->data['logout']))
		{
			$this->auth->logout();
		}
		$this->user = $this->auth->adminLoggedIn();
		$this->message = $message;
	}

	/**
	 * Controls and displays CMS login page
	 *
	 * @return	\Illuminate\Support\Facades\View
	 */
	public function login()
	{
		if ($this->user)
		{
			return Redirect::route('admin');
		}

		if($this->data)
		{
			$validation = Validator::make($this->data,
				array(
					'email' => 'required|email',
					'password' => 'required',
					)
				);

			if (!$validation->fails())
			{
				if ($this->auth->adminLogin($this->data['email'], $this->data['password']))
				{
					return Redirect::route('admin');
				}
			}

			$this->message->setMessages(array(
					'error' => array(
						'Invalid login details',
						)
					));
		}
		$messages = $this->message->getMessages();
		$data = $this->data;
		return View::make('theme::login', compact('messages', 'data'));
	}

	/**
	 * Controls and displays CMS main dashboard
	 *
	 * @return	\Illuminate\Support\Facades\View
	 */
	public function dashboard()
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}
		$messages = $this->message->getMessages();
		return View::make('theme::sections.dashboard', compact('messages'));
	}

	/**
	 * Controls and displays CMS module page
	 *
	 * @return	\Illuminate\Support\Facades\View
	 */
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