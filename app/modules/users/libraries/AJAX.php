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

	public function switchUserGroupsStatus($data)
	{
		$results = $this->users->switchUserGroupsStatus($data['group_id']);
		if ($results)
		{
			return 'success';
		}
		return 'error';
	}
}