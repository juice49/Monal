<?php namespace App\Modules\Users\Contracts;

interface UserModelInterface {

	public static function findByEmail($email);
}