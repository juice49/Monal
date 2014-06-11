<?php
namespace Monal\Models;
/**
 * Model.
 *
 * This is the base Model class for all system models.
 *
 * @author  Arran Jacques
 */

class Model {

	/**
	 * The model's message bag.
	 *
	 * @var     Illuminate\Support\MessageBag
	 */
	protected $messages;

	/**
	 * Constructor.
	 *
	 * @return  Void
	 */
	public function __construct()
	{
		$this->messages = \App::make('Illuminate\Support\MessageBag');
	}

	/**
	 * Return the model's message bag.
	 *
	 * @return  Illuminate\Support\MessageBag
	 */
	public function messages()
	{
		return $this->messages;
	}
}