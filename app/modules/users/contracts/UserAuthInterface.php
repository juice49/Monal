<?php namespace App\Modules\Users\Contracts;

interface UserAuthInterface {

	public function __construct(\App\Modules\Users\Contracts\UserInterface $user);
	
	public function adminLogin($email = null, $password = null);

	public function logout();

	public function adminLoggedIn();
}