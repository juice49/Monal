<?php
namespace Monal\Core\Contracts;
/**
 * Messages Interaface.
 *
 * Contract for system messages class.
 *
 * @author	Arran Jacques
 */

interface MessagesInterface
{
	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct();

	/**
	 * Return instance's messages.
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function get();

	/**
	 * Add messages to the instance's message set.
	 *
	 * @param	Array
	 * @return	Mixed
	 */
	public function add(array $messages);

	/**
	 * Flash instance's messages set to session.
	 *
	 * @return	Void
	 */
	public function flash();
}