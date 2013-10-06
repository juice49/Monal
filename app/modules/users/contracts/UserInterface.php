<?php namespace App\Modules\Users\Contracts;

interface UserInterface {

	public function __construct(\App\Modules\Users\Contracts\UserModelInterface $model);

	public function setUser(array $user);
	
	public function hasPrivileges();
}