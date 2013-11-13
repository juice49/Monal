<?php namespace App\Modules\Messages\Contracts;

interface MessagesInterface {
	
	public function __construct();

	/**
	 * Return instance's messages
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function getMessages();

	/**
	 * Add messages to the instance's message set
	 *
	 * @param	Array
	 * @return	Self
	 */
	public function setMessages($messages = array());

	/**
	 * Flash instance's messages set to session
	 *
	 * @return	Void
	 */
	public function flash();
}