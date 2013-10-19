<?php namespace App\Modules\Messages;
/**
 * Message
 *
 * Library for managing global app messages 
 *
 * @author Arran Jacques
 */

use Illuminate\Support\MessageBag;

class Messages implements Contracts\MessagesInterface {

	protected $messages;

	public function __construct()
	{
		$this->messages = new MessageBag();
	}

	/**
	 * Return object's messages
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function getMessages()
	{
		// Check if messages have been flashed to the session. If they have
		// merge them into the objects message set
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
	 * Add messages to the object's message set
	 *
	 * @param	array
	 * @return	self
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
	 * Flash object's messages set to session
	 *
	 * @return	void
	 */
	public function flash()
	{
		if (isset($this->messages))
		{
			\Session::flash('messages', $this->messages);
		}
	}
}