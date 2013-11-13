<?php namespace App\Modules\Messages;
/**
 * Messages
 *
 * Library for managing system messages
 *
 * @author Arran Jacques
 */

use App\Modules\Messages\Contracts\MessagesInterface;
use Illuminate\Support\MessageBag;

class Messages implements MessagesInterface {

	/**
	 * Instance's messages
	 *
	 * @var		Illuminate\Support\MessageBag
	 */
	protected $messages;


	public function __construct()
	{
		$this->messages = new MessageBag();
	}

	/**
	 * Return instance's messages
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function getMessages()
	{
		// Check if messages have been flashed to the session. If they have
		// merge them into the instance's message set
		if (\Session::has('messages'))
		{
			$flash_messages = \Session::get('messages');

			$flash_messages = $flash_messages->toArray();
			foreach ($flash_messages as $key => $flash_message)
			{
				foreach ($flash_message as $msg)
				{
					$this->messages->add($key, $msg);
				}
			}
		}
		if ($this->messages->count() > 0)
		{
			return $this->messages;
		}
		return false;
	}

	/**
	 * Add messages to the instance's message set
	 *
	 * @param	Array
	 * @return	Self
	 *
	 * Use:
	 * setMessages(array(
	 *		'set_name' => array(
	 *			'set message one',
	 *			'set message two',
	 *		)
	 *	))
	 */
	public function setMessages($messages = array())
	{
		if (is_array($messages) && !empty($messages))
		{
			foreach ($messages as $key => $message_set)
			{
				foreach ($message_set as $message)
				{
					$this->messages->add($key, $message);
				}
			}
		}
		return $this;
	}

	/**
	 * Flash instance's messages set to session
	 *
	 * @return	Void
	 */
	public function flash()
	{
		if (isset($this->messages))
		{
			\Session::flash('messages', $this->messages);
		}
	}
}