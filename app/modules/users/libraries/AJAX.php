<?php
/**
 * Users AJAX
 *
 * Library of functions for the users module specifically for mapping
 * ajax requests to
 *
 * @author Arran Jacques
 */

class UsersAJAX {

	public function __construct()
	{
		$this->users = new App\Modules\Users\UsersManager();
	}

	/**
	 * Switches a user's active status around
	 *
	 * @param	Array
	 * @return	JSON
	 */
	public function switchUsersStatus($data)
	{
		$results = array();
		$user = $this->users->getUser($data['user_id']);
		if ($user['group']['active'])
		{
			if ($user['active'] && $user['group']['id'] == 1)
			{
				if ($this->users->countActiveAdministrators() <= 1)
				{
					$results['status'] = 'error';
					$results['message'] = 'This is the only ' . $user['group']['name'] . ' user. You must have at least one active Administrator.';
					return json_encode($results, JSON_FORCE_OBJECT);
				}
			}
			if ($this->users->switchUsersStatus($data['user_id']))
			{
				$results['status'] = 'success';
			}
			else
			{
				$results['status'] = 'error';
				$results['message'] = 'There was an error processing your request. Please try again.';
			}
		}
		else
		{
			$results['status'] = 'error';
			$results['message'] = 'The user group this user is part of is inactive. You can\'t make this user active.';
		}
		return json_encode($results, JSON_FORCE_OBJECT);
	}

	/**
	 * Switches a group's active status around
	 *
	 * @param	Array
	 * @return	JSON
	 */
	public function switchUserGroupsStatus($data)
	{
		$results = array();
		if($data['group_id'] != 1)
		{
			if ($this->users->switchUserGroupsStatus($data['group_id']))
			{
				$results['status'] = 'success';
			}
			else
			{
				$results['status'] = 'error';
				$results['message'] = 'There was an error processing your request. Please try again.';
			}
		}
		else
		{
			$results['status'] = 'error';
			$results['message'] = 'You can\'t make the Administrator group inactive.';
		}
		return json_encode($results, JSON_FORCE_OBJECT);
	}
}