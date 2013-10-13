<?php
/**
 * Users Controller
 *
 * Controller for Users Module CMS admin pages
 *
 * @author Arran Jacques
 */

use App\Modules\Users\Contracts\UserAuthInterface;
use App\Modules\Messages\Contracts\MessagesInterface;
use App\Modules\Module\Contracts\ModuleManagerInterface;
use App\Modules\Users\Contracts\UsersManagerInterface;

class UsersController extends AdminController {

	public function __construct(UsersManagerInterface $users, UserAuthInterface $auth, MessagesInterface $message, ModuleManagerInterface $module)
	{
		parent::__construct($auth, $message, $module);
		$this->users = $users;
	}

	/**
	 * Controls and displays users page
	 *
	 * @return	\Illuminate\View\View
	 */
	public function users()
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}
		$users = $this->users->getUsers();
		$messages = $this->message->getMessages();
		return View::make('users::users', compact('messages', 'users'));
	}

	/**
	 * Controls and displays user groups page
	 *
	 * @return	\Illuminate\View\View
	 */
	public function userGroups()
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}
		$user_groups = $this->users->getUserGroups();
		$messages = $this->message->getMessages();
		return View::make('users::user_groups', compact('messages', 'user_groups'));
	}

	/**
	 * Controls and displays add user group page
	 *
	 * @return	\Illuminate\View\View
	 */
	public function addUserGroup()
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}
		if ($this->data)
		{
			$validation = Validator::make($this->data,
				array(
					'name' => 'required|min:3',
					)
				);

			if ($validation->passes())
			{
				$this->data['active'] = (isset($this->data['active'])) ? 1 : 0;

				if ($this->users->saveUserGroup($this->data))
				{
					$this->message->setMessages(array(
						'success' => array(
							'User group created',
							)
						))->flash();
					return Redirect::route('admin.users.groups');
				}
				else
				{
					$this->message->setMessages(array(
						'error' => array(
							'There was an error adding this user group',
							)
						));
				}
			}
			else
			{
				$this->message->setMessages($validation->messages()->toArray());
			}
		}
		$messages = $this->message->getMessages();
		return View::make('users::add_user_group', compact('messages'));
	}

	/**
	 * Formats a list of user groups into a simple array where the
	 * key is the group ID and the value is the group name
	 *
	 * @param	array
	 * @return	array
	 */
	public function formatUserGroups(array $user_groups)
	{
		$formated_user_groups = array();
		if (!empty($user_groups))
		{
			foreach ($user_groups as $group)
			{
				$formated_user_groups[$group['id']] = $group['name'];
			}
		}
		return $formated_user_groups;
	}
}