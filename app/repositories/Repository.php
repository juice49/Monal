<?php
namespace Monal\Repositories;
/**
 * Repository.
 *
 * This is the base class for all system repositories.
 *
 * @author  Arran Jacques
 */

class Repository {

	/**
	 * The repository's message bag.
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
	 * Return the repository's message bag.
	 *
	 * @return  Illuminate\Support\MessageBag
	 */
	public function messages()
	{
		return $this->messages;
	}
}