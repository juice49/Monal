<?php 
/**
 *
 */
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use App\Modules\Users\Contracts\UserModelInterface;

class Users_m extends Eloquent implements UserInterface, RemindableInterface, UserModelInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function checkUserCredentials($email = null, $password = null)
	{
		if (!$email or !$password)
		{
			return false;
		}
		if (Auth::attempt(array('email' => $email, 'password' => $password), false))
		{
			return true;
		}
		return false;
	}

}