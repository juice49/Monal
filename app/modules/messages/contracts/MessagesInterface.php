<?php namespace App\Modules\Messages\Contracts;

interface MessagesInterface {
	
	public function __construct();

	public function getMessages();

	public function setMessages($messages = array());

	public function flash();
}