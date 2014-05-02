<?php
namespace Monal\Core;
/**
 * Messages.
 *
 * @author	Arran Jacques
 */

use Monal\Core\Contracts\MessagesInterface;

class Messages implements MessagesInterface
{
	/**
	 * Message Bag.
	 *
	 * @var		Illuminate\Support\MessageBag
	 */
	protected $messages;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->messages = new \Illuminate\Support\MessageBag;
	}

	/**
	 * Return instance's messages.
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function get()
	{
		// Check if messages have been flashed to the session. If they have
		// merge them into the instance's message set
		if (\Session::has('messages')) {
			$flash_messages = \Session::get('messages');
			$flash_messages = $flash_messages->toArray();
			foreach ($flash_messages as $key => $flash_message) {
				foreach ($flash_message as $msg) {
					$this->messages->add($key, $msg);
				}
			}
		}
		return ($this->messages->count() > 0) ? $this->messages: false;
	}

	/**
	 * Add messages to the instance's message set.
	 *
	 * @param	Array
	 * @return	Messages
	 *
	 * Use:
	 * setMessages(array(
	 *		'set_name' => array(
	 *			'set message one',
	 *			'set message two',
	 *		)
	 *	))
	 */
	public function add(array $messages)
	{
		foreach ($messages as $key => $message_set) {
			foreach ($message_set as $message) {
				$this->messages->add($key, $message);
			}
		}
		return $this;
	}

	/**
	 * Flash instance's messages set to session.
	 *
	 * @return	Void
	 */
	public function flash()
	{
		\Session::flash('messages', $this->messages);
	}
}