<?php namespace App\Modules\Users;
/**
 *
 */

class User implements Contracts\UserInterface {

	public function __construct(\App\Modules\Users\Contracts\UserModelInterface $model)
	{
		$this->model = $model;
	}

	public function hasPrivileges()
	{
		if ($this->data['role'] == 1)
		{
			return true;
		}
		return false;
	}

}