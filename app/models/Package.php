<?php
namespace Monal\Models;
/**
 * Package.
 *
 * A model of a system package.
 *
 * @author	Arran Jacques
 */

class Package
{
	/**
	 * The package's messages.
	 *
	 * @var		Monal\Core\Contracts\MessagesInterface
	 */
	protected $messages;

	/**
	 * The package's ID.
	 *
	 * @var		Integer
	 */
	protected $id = null;

	/**
	 * The package's name.
	 *
	 * @var		String
	 */
	protected $name = null;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->messages = \App::make('Monal\Core\Contracts\MessagesInterface');
	}

	/**
	 * Return the package's messages.
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function messages()
	{
		return $this->messages->get();
	}

	/**
	 * Return the package's ID.
	 *
	 * @return	Integer
	 */
	public function ID()
	{
		return (integer) $this->id;
	}

	/**
	 * Return the package's name.
	 *
	 * @return	String
	 */
	public function name()
	{
		return $this->name;
	}

	/**
	 * Set the package's ID.
	 *
	 * @param	Integer
	 * @return	Void
	 */
	public function setID($id)
	{
		$this->id = (integer) $id;
	}

	/**
	 * Set the package's name.
	 *
	 * @param	String
	 * @return	Void
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Check the package validates against a set of given rules.
	 *
	 * @param	Array
	 * @param	Array
	 * @return	Boolean
	 */
	public function validates(array $validation_rules = array(), array $validation_messages = array())
	{
		$data = array(
			'name' => $this->name,
		);
		$validation = \Validator::make($data, $validation_rules, $validation_messages);
		if ($validation->passes()) {
			return true;
		} else {
			$this->messages->add($validation->messages()->toArray());
			return false;
		}
	}
}