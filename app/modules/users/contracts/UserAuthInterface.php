<?php namespace App\Modules\Users\Contracts;
/**
 *
 */

interface UserAuthInterface {

	public function __construct(\App\Modules\Users\Contracts\UserInterface $user);
	
	public function login($email = null, $password = null);

	public function loggedIn();

}