<?php
/**
 * Settings Repository.
 *
 * Repository for storing System Settings.
 *
 * @author	Arran Jacques
 */

use Fruitful\Models\Setting;

class SettingsRepository
{
	/**
	 * The database table the repository uses.
	 *
	 * @var		String
	 */
	protected $table = 'settings';

	/**
	 * The repository's messages.
	 *
	 * @var		 Fruitful\Core\Contracts\MessagesInterface
	 */
	protected $messages;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->messages = \App::make('Fruitful\Core\Contracts\MessagesInterface');
	}

	/**
	 * Return the repository's messages.
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function messages()
	{
		return $this->messages->get();
	}

	/**
	 * Return a new Settings model.
	 *
	 * @return	Fruitful\Data\Models\DataSet
	 */
	public function newModel()
	{
		return \App::make('Fruitful\Models\Setting');
	}

	/**
	 * Check a Data Set model validates for storage.
	 *
	 * @param	Fruitful\Models\Setting
	 * @return	Boolean
	 */
	public function validatesForStorage(Setting $setting)
	{
		// Allow alpha, numeric, hypens, underscores and space characters.
		\Validator::extend('setting', function($attribute, $value, $parameters)
		{
			return preg_match('/^[a-z0-9 \-_]+$/i', $value) ? true : false;
		});
		$unique_exception = ($setting->ID()) ? ',' . $setting->ID() : null;
		$validation_rules = array(
			'key' => 'required|max:60|setting|unique:settings,key' . $unique_exception,
			'value' => 'max:255' . $unique_exception,
		);
		$validation_messages = array(
			'key.required' => 'You need to give this setting a Key.',
			'key.max' => 'The Key for this setting is to long. It must be no more than 60 characters long.',
			'key.setting' => 'The Key for this setting is invalid. It can only contain letter, numbers, underscores, hyphens and spaces.',
			'key.unique' => 'There is already a setting using this key. Please choose a different one.',
			'value.max' => 'The Value for this setting is to long. It must be no more than 255 characters long.',
		);
		if ($setting->validates($validation_rules, $validation_messages)) {
			return true;
		} else {
			$this->messages->add($setting->messages()->toArray());
			return false;
		}
	}

	/**
	 * Encode a Setting model so it is ready to be stored in the
	 * repository.
	 *
	 * @param	Fruitful\Models\Settings
	 * @return	Array
	 */
	protected function encodeForStorage(Setting $setting)
	{
		return array(
			'key' => $setting->key(),
			'value' => $setting->value(),
		);
	}

	/**
	 * Decode a Settings repository entry into its model class.
	 *
	 * @param	stdClass
	 * @return	Fruitful\Models\Setting
	 */
	protected function decodeFromStorage($result)
	{
		$setting = $this->newModel();
		$setting->setID($result->id);
		$setting->setKey($result->key);
		$setting->setValue($result->value);
		return $setting;
	}

	/**
	 * Retrieve an instance/s from the repository.
	 *
	 * @param	Integer
	 * @return	Illuminate\Database\Eloquent\Collection / Fruitful\Models\Setting
	 */
	public function retrieve($key = null)
	{
		$query = \DB::table($this->table);
		if (!$key) {
			$results = $query->select('*')->get();
			$settings = \App::make('Illuminate\Database\Eloquent\Collection');
			foreach ($results as $result) {
				$settings->add($this->decodeFromStorage($result));
			}
			return $settings;
		} else {
			if ($result = $query->where('id', '=', $key)->first()) {
				return $this->decodeFromStorage($result);
			}
		}
		return false;
	}

	/**
	 * Retrieve an instance from the repository using it's key.
	 *
	 * @param	String
	 * @return	Fruitful\Models\Setting
	 */
	public function retrieveByKey($key)
	{
		if ($result = \DB::table($this->table)->where('key', '=', $key)->first()) {
			return $this->decodeFromStorage($result);
		}
		return false;
	}

	/**
	 * Write a Setting model to the repository.
	 *
	 * @param	Fruitful\Models\Setting
	 * @return	Boolean
	 */
	public function write(Setting $setting)
	{
		if ($this->validatesForStorage($setting)) {
			$encoded = $this->encodeForStorage($setting);
			if ($setting->ID()) {
				$encoded['updated_at'] = date('Y-m-d H:i:s');
				\DB::table($this->table)->where('id', '=', $setting->ID())->update($encoded);
				return true;
			} else {
				$encoded['created_at'] = date('Y-m-d H:i:s');
				$encoded['updated_at'] = date('Y-m-d H:i:s');
				\DB::table($this->table)->insert($encoded);
				return true;
			}
		}
		return false;
	}
}