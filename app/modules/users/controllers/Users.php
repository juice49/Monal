<?php
/**
 * Users Controller
 *
 * Controller for Users Module's CMS admin pages
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
	 * Controls and displays add user page
	 *
	 * @return	\Illuminate\View\View
	 */
	public function addUser()
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}
		if ($this->data)
		{
			$validation = Validator::make($this->data,
				array(
					'first_name' => 'required|alpha|min:2',
					'last_name' => 'required|alpha|min:2',
					'username' => 'required|min:2|alpha_dash|unique:users',
					'email' => 'required|email|unique:users',
					'password' => 'required|min:6|confirmed',
					'password_confirmation' => 'required|min:6',
					'user_group' => 'required',
					)
				);

			if ($validation->passes())
			{
				$this->data['active'] = (isset($this->data['active'])) ? 1 : 0;

				if ($this->users->createUser($this->data))
				{
					$this->message->setMessages(array(
						'success' => array(
							'User created',
							)
						))->flash();
					return Redirect::route('admin.users');
				}
				else
				{
					$this->message->setMessages(array(
						'error' => array(
							'There was an error creating this user. Please try again.',
							)
						));
				}
			}
			else
			{
				$this->message->setMessages($validation->messages()->toArray());
			}
		}
		$user_groups = $this->formatUserGroups($this->users->getUserGroups());
		$messages = $this->message->getMessages();
		return View::make('users::add_user', compact('messages', 'user_groups'));
	}

	/**
	 * Controls and displays edit user page
	 *
	 * @param	Int
	 * @return	\Illuminate\View\View
	 */
	public function editUser($user_id)
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}

		if (isset($user_id) && $user = $this->users->getUser($user_id))
		{
			if ($this->data)
			{
				$validation = Validator::make($this->data,
					array(
						'first_name' => 'required|alpha|min:2',
						'last_name' => 'required|alpha|min:2',
						'username' => 'required|min:2|alpha_dash|unique:users,username,' . $user_id,
						'email' => 'required|email|unique:users,email,' . $user_id,
						'password' => 'min:6|confirmed',
						'password_confirmation' => 'min:6',
						'user_group' => 'required',
						)
					);

				if ($validation->passes())
				{
					$this->data['active'] = (isset($this->data['active'])) ? 1 : 0;
					if ((!$this->data['active'] && $user['group']['id'] == 1) || ($this->data['user_group'] != 1 && $user['group']['id'] == 1))
					{
						if ($this->users->countActiveAdministrators() <= 1)
						{
							$this->message->setMessages(array(
									'error' => array(
										'This is the only ' . $user['group']['name'] . ' user. You must have at least one active Administrator.',
										)
									));
							$user_groups = $this->formatUserGroups($this->users->getUserGroups());
							$messages = $this->message->getMessages();
							return View::make('users::edit_user', compact('messages', 'user', 'user_groups'));
						}
					}
					if ($this->users->editUser($user_id, $this->data))
					{
						$this->message->setMessages(array(
								'success' => array(
									'Changes to user saved.',
									)
								))->flash();
						return Redirect::route('admin.users');
					}
					else
					{
						$this->message->setMessages(array(
								'error' => array(
									'There was an error editing this user. Please try again.',
									)
								));
					}
				}
				else
				{
					$this->message->setMessages($validation->messages()->toArray());
				}
			}
			$user_groups = $this->formatUserGroups($this->users->getUserGroups());
			$messages = $this->message->getMessages();
			return View::make('users::edit_user', compact('messages', 'user', 'user_groups'));
		}
		else
		{
			return Redirect::route('admin.users');
		}
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
					'name' => 'required|alpha_num|unique:user_groups',
					)
				);

			if ($validation->passes())
			{
				$this->data['active'] = (isset($this->data['active'])) ? 1 : 0;

				if ($this->users->createUserGroup($this->data))
				{
					$this->message->setMessages(array(
						'success' => array(
							'The user group ' . $this->data['name'] . ' was created.',
							)
						))->flash();
					return Redirect::route('admin.users.groups');
				}
				else
				{
					$this->message->setMessages(array(
						'error' => array(
							'There was an error adding this user group. Please try again.',
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
	 * Controls and displays edit user group page
	 *
	 * @param	Int
	 * @return	\Illuminate\View\View
	 */
	public function editUserGroup($group_id)
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}

		if (isset($group_id) && $user_group = $this->users->getUserGroup($group_id))
		{
			if ($this->data)
			{
				$validation = Validator::make($this->data,
					array(
						'name' => 'required|alpha_num|unique:user_groups,name,' . $group_id,
						)
					);

				if ($validation->passes())
				{
					$this->data['active'] = (isset($this->data['active'])) ? 1 : 0;

					if ($this->users->editUserGroup($group_id, $this->data))
					{
						$this->message->setMessages(array(
							'success' => array(
								'Changes to the user group ' . $this->data['name'] . ' where saved.',
								)
							))->flash();
						return Redirect::route('admin.users.groups');
					}
					else
					{
						$this->message->setMessages(array(
							'error' => array(
								'There was an error editing this user group. Please try again.',
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
			return View::make('users::edit_user_group', compact('messages', 'user_group'));
		}
		else
		{
			return Redirect::route('admin.users.groups');
		}
	}

	/**
	 * Formats a list of user groups into a simple array where the
	 * key is the group ID and the value is the group name
	 *
	 * @param	Array
	 * @return	Array
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