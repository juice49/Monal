<?php
namespace Monal\Models;
/**
 * Setting.
 *
 * Model for a single system setting.
 *
 * @author	Arran Jacques
 */

class Setting
{
	/**
	 * The model's messages.
	 *
	 * @var		 Monal\Core\Contracts\MessagesInterface
	 */
	protected $messages;

	/**
	 * The setting's ID.
	 *
	 * @var		Integer
	 */
	protected $id = null;

	/**
	 * The setting's key.
	 *
	 * @var		String
	 */
	protected $key = null;

	/**
	 * The setting's value.
	 *
	 * @var		String
	 */
	protected $value = null;

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
	 * Return the setting's messages.
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function messages()
	{
		return $this->messages->get();
	}

	/**
	 * Return the setting's ID.
	 *
	 * @return	Integer
	 */
	public function ID()
	{
		return (integer) $this->id;
	}

	/**
	 * Return the setting's key.
	 *
	 * @return	String
	 */
	public function key()
	{
		return $this->key;
	}

	/**
	 * Return the setting's value.
	 *
	 * @return	String
	 */
	public function value()
	{
		return $this->value;
	}

	/**
	 * Set the setting's ID.
	 *
	 * @param	Integer
	 * @return	Void
	 */
	public function setID($id)
	{
		$this->id = (integer) $id;
	}

	/**
	 * Set the setting's key.
	 *
	 * @param	String
	 * @return	Void
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * Set the setting's value.
	 *
	 * @param	String
	 * @return	Void
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

	/**
	 * Check the setting validates against a set of given rules.
	 *
	 * @param	Array
	 * @param	Array
	 * @return	Boolean
	 */
	public function validates(array $validation_rules = array(), array $validation_messages = array())
	{
		$data = array(
			'key' => $this->key,
			'value' => $this->value,
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