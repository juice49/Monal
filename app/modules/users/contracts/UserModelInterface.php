<?php namespace App\Modules\Users\Contracts;
/**
 *
 */

interface UserModelInterface {

	public function getAuthIdentifier();

	public function getAuthPassword();

	public function getReminderEmail();

}